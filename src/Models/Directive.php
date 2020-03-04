<?php

namespace Maestriam\Samurai\Models;

use Illuminate\Support\Facades\Blade;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Traits\FoundationScope;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
use Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException;

class Directive
{
    use FoundationScope;

    /**
     * Nome da diretiva
     *
     * @var string
     */
    private $name = '';

    /**
     * Tipo da diretiva
     *
     * @var string
     */
    private $type = '';

    /**
     * Tema de origem
     *
     * @var Theme
     */
    private $theme;

    /**
     * Caminho do arquivo
     *
     * @var string
     */
    private $path = '';

    /**
     * Undocumented function
     *
     * @param string $name
     * @param string $type
     * @param Theme $theme
     * @return void
     */
    public function __construct(string $name, string $type, Theme $theme)
    {
        $this->setTheme($theme);
        $this->setType($type);
        $this->setName($name);
        $this->setFilename($name);
        $this->setFolder($name);
        $this->setPath($name);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create() : ?Directive
    {
        $this->file()->mkFolder($this->path);

        $absolute = $this->absolute();
        $content  = $this->stub();

        $this->file()->mkFile($absolute, $content);

        return (is_file($absolute)) ? $this : null;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function load()
    {
        $theme = $this->theme->name;
        $file  = $this->absolute();
        $path = $this->nominator()->blade($theme, $file);

        if ($this->type == 'include') {
            return Blade::include($path, $this->name);
        }

        return Blade::component($path, $this->name);
    }

    public function findOrCreate()
    {

    }

    public function get()
    {

    }

    private function stub()
    {
        $path = __DIR__ . DS .  "../Stubs/{$this->type}.stub";
        $stub = file_get_contents($path);

        return str_replace('{{name}}', $this->name, $stub);
    }


    public function absolute()
    {
        return $this->path . $this->filename;
    }

    /**
     * Undocumented function
     *
     * @param Theme $theme
     * @return void
     */
    private function setTheme(Theme $theme)
    {
        if (! $theme instanceof Theme) {
            throw new ThemeNotFoundException($theme);
        }

        $this->theme = $theme;
        return $this;
    }

    /**
     *
     *
     * @param string $folder
     * @return void
     */
    private function setFolder(string $name)
    {
        $pieces = explode('/', $name);

        array_pop($pieces);

        $folder = implode(DS, $pieces);

        $this->folder = (! strlen($folder)) ? null : $folder;
        return $this;
    }

    /**
     *
     *
     * @param string $name
     * @return void
     */
    private function setName(string $name)
    {
        if (! $this->valid()->directive($name)) {
            throw new InvalidDirectiveNameException($name);
        }

        $this->name = strtolower($name);
        return $this;
    }

    /**
     * Define o nome do arquivo para ser chamado no projeto
     *
     * @param string $name
     * @return void
     */
    private function setFilename(string $name)
    {
        $file = $this->nominator()->filename($name, $this->type);

        $this->filename = $file;
        return $this;
    }

    /**
     * Define o tipo da diretiva
     *
     * @param string $type
     * @return Directive
     */
    private function setType(string $type) : Directive
    {
        if (! $this->valid()->type($type)) {
            throw new InvalidTypeDirectiveException($type);
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return Directive
     */
    private function setPath() : Directive
    {
        $name  = $this->name . DS;
        $theme = $this->theme->filepath();

        if ($this->folder == null) {
            $folder = $this->folder . DS;
        }

        $this->path = $theme . $folder . $name;

        return $this;
    }
}
