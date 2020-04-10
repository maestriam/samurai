<?php

namespace Maestriam\Samurai\Models;

use Str;
use Maestriam\Samurai\Models\Theme;
use Illuminate\Support\Facades\Blade;
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
     * Sentença que foi inserida pelo usuário, 
     * que irá fornecer o nome/sub-diretório
     *
     * @var string
     */
    private $sentence = '';

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
    public function __construct(string $sentence, string $type, Theme $theme)
    {
        $this->setSentence($sentence);
        $this->setTheme($theme);
        $this->setType($type);
        $this->setName($sentence);
        $this->setAlias($sentence);
        $this->setFilename();
        $this->setFolder($sentence);
        $this->setPath($sentence);
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
        $file  = $this->relative();
        $theme = $this->theme->namespace;
        $path  = $this->nominator()->blade($theme, $file);

        if ($this->type == 'include') {
            return $this->loadInclude($path, $this->alias);
        }
        
        return $this->loadComponent($path, $this->alias);
    }
    
    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $alias
     * @return void
     */
    private function loadInclude(string $path, string $alias)
    {
        return Blade::include();
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $alias
     * @return void
     */
    private function loadComponent(string $path, string $alias)
    {
        if (method_exists(Blade::class, 'component')) {
            return Blade::component($path, $alias);
        }

        return Blade::aliasComponent($path, $alias);
    }

    /**
     * Retorna o conteúdo para criação da diretiva de acordo
     * com o tipo que será criado (include/component)
     *
     * @return void
     */
    private function stub()
    {
        $stub = $this->file()->stub($this->type);

        return str_replace('{{name}}', $this->name, $stub);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function absolute()
    {
        return $this->path . $this->filename;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function relative()
    {
        $file = $this->absolute();
        $path = $this->theme->path . DS;

        return str_replace($path, '', $file);
    }
    
    /**
     * Undocumented function
     *
     * @param Theme $theme
     * @return void
     */
    private function setSentence(string $sentence) : self
    {
        $parsed = $this->parser()->filename($sentence);

        if (! property_exists($parsed, 'name')) {
            throw new InvalidDirectiveNameException($sentence);
        }

        if (! $this->valid()->directive($parsed->name)) {
            throw new InvalidDirectiveNameException($sentence);
        }

        $this->sentence = strtolower($sentence);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param Theme $theme
     * @return void
     */
    private function setTheme(Theme $theme) : self
    {
        if (! $theme instanceof Theme) {
            throw new ThemeNotFoundException($theme);
        }

        $this->theme = $theme;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return Directive
     */
    private function setName(string $name) : self
    {
        $request = $this->parser()->filename($name);

        $this->name = Str::slug($request->name);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return Directive
     */
    private function setAlias(string $name) : self
    {
        $name = $this->name;

        $this->alias = $this->nominator()->alias($name);
        return $this;
    }

    /**
     *
     *
     * @param string $folder
     * @return void
     */
    private function setFolder(string $name) : self
    {
        $request = $this->parser()->filename($name);

        $this->folder = Str::slug($request->folder);
        return $this;
    }

    /**
     * Define o nome do arquivo para ser chamado no projeto
     *
     * @param string $name
     * @return void
     */
    private function setFilename() : self
    {
        $file = $this->nominator()->filename($this->name, $this->type);

        $this->filename = $file;
        return $this;
    }

    /**
     * Define o tipo da diretiva
     *
     * @param string $type
     * @return Directive
     */
    private function setType(string $type) : self
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
    private function setPath() : self
    {
        $folder = null; 
        $name   = $this->name . DS;
        $theme  = $this->theme->filepath() . DS;

        if ($this->folder != null) {
            $folder = $this->folder . DS;
        }

        $this->path = $theme . $folder . $name;
        return $this;
    }
}
