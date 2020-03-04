<?php

namespace Maestriam\Samurai\Models;

use Illuminate\Support\Facades\Blade;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Foundation;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
use Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException;

class Directive extends Foundation
{
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
    * Apelido pelo qual é chamado dentro do projeto
    *
    * @var string
    */ 
    private $alias = '';

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
        $this->setAlias($name);
        $this->setFilename();
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
            return Blade::include($path, $this->alias);
        }

        return Blade::component($path, $this->alias);
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

    private function setAlias(string $name)
    {
        $request = $this->parser()->filename($name);

        $this->alias = $request->name;
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
        $request = $this->parser()->filename($name);

        $this->folder = $request->folder;
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
    private function setFilename()
    {
        $file = $this->nominator()
                     ->filename($this->alias, $this->type);

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
        $folder = null; 
        $name   = $this->alias . DS;
        $theme  = $this->theme->filepath() . DS;

        if ($this->folder != null) {
            $folder = $this->folder . DS;
        }

        $this->path = $theme . $folder . $name;

        return $this;
    }
}
