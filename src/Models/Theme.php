<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Models\Structure;
use Maestriam\Samurai\Exceptions\ThemeExistsException;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

class Theme extends Structure
{
    /**
     * Nome da diretiva
     *
     * @var string
     */
    public $name = '';

    /**
     * Caminho do arquivo
     *
     * @var string
     */
    public $path = '';

    /**
     * Apelido para ser chamado pelo Laravel Blade
     *
     * @var string
     */
    public $namespace = '';

    /**
     * Undocumented function
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct();

        $this->setPath($name);
        $this->setName($name);
        $this->setNamespace($name);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function build()
    {
        if ($this->exists($this->name)) {
            throw new ThemeExistsException($this->name);
        }

        return $this->file->mkFolder($this->path);
    }

    /**
     * Retorna a instância de uma include para
     * um determinado tema
     *
     * @param string $name
     * @return Directive
     */
    public function include(string $name) : Directive
    {
        $type = 'include';

        return new Directive($name, $type, $this);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return Directive
     */
    public function component(string $name) : Directive
    {
        $type = 'component';

        return new Directive($name, $type, $this);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function publish()
    {

    }

    public function load()
    {

    }

    public function directives()
    {

    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @return boolean
     */
    public function exists(string $name) : bool
    {
        $theme = $this->dir->theme($name);

        return (is_dir($theme));
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return boolean
     */
    public function isValidName(string $name) : bool
    {
        return $this->valid->themeName($name);
    }

    /**
     * Define o nome do tema
     *
     * @param string $name
     * @return $this
     */
    private function setName(string $name)
    {
        if (! $this->isValidName($name)) {
            throw new InvalidThemeNameException($name);
        }

        $this->name = $name;
        return $this;
    }

    /**
     * Define o "apelido" para ser chamado no projeto
     *
     * @param string $name
     * @return void
     */
    private function setNamespace(string $name)
    {
        $this->namespace = $this->nominator->namespace($name);
        return $this;
    }

    /**
     * Define o caminho do tema
     *
     * @param string $name
     * @return void
     */
    private function setPath(string $name)
    {
        $this->path = $this->dir->theme($name);
        return $this;
    }
}
