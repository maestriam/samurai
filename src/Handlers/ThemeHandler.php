<?php

namespace Maestriam\Samurai\Handlers;

use Maestriam\Samurai\Models\Theme;
use Illuminate\Support\Facades\Config;
use Maestriam\Samurai\Traits\HandlerFunctions;

class ThemeHandler
{
    use HandlerFunctions;

    /**
     * Armazena o nome do tema para ser manipulado
     *
     * @var string
     */
    protected $name = '';

    /**
     * Define o nome do tema que será manipulado
     *
     * @param string $name
     * @return $this
     */
    public function set(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Retorna as propriedades de um tema
     *
     * @return Theme
     */
    public function get($name) : Theme
    {
        return $this->objectTheme($name);
    }

    /**
     * Constrói o diretório base para temas
     *
     * @return string
     */
    public function makeBase() : string
    {
        $base = $this->baseFolder();

        if ($this->existsBase()) {
            return $base;
        }

        mkdir($base);

        return $base;
    }


    /**
     * Retorna todos os temas criados
     *
     * @return array
     */
    public function all() : array
    {
        $base = $this->baseFolder();

        if (! $this->exists($base)) {
            return [];
        }

        $themes = scandir($base);
        $themes = array_splice($themes, 2);

        return $themes;
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return array
     */
    public function directives(string $name) : array
    {
        $collection = [];

        $types = $this->types();

        if (empty($types)) return $collection;

        foreach($types as $type) {
            $collection[$type] = $this->extract($name, $type);
        }

        return $collection;
    }

    /**
     * Cria um novo diretório de tema
     *
     * @param string $name
     * @return void
     */
    public function create($name)
    {
        if (! $this->existsBase()) {
            $this->makeBase();
        }

        $path = $this->path($name);

        if ($this->exists($name)) {
            return $this->objectTheme($name);
        }

        mkdir($path);

        return $this->objectTheme($name);
    }

    /**
     * Retorna um caminho absoluto de um
     *
     * @param string $name
     * @return string
     */
    public function path(string $name) : string
    {
        return $this->themePath($name);
    }

    /**
     * Verifica se o nome informado para o tema
     * segue os padrões
     *
     * @return boolean
     */
    public function isValidName($name) : bool
    {
        $startNumbers   = "/^[\d]/";
        $onlyValidChars = "/^[\w&.\-]+$/";

        if (preg_match($startNumbers, $name)) {
            return false;
        }

        if (! preg_match($onlyValidChars, $name)) {
            return false;
        }

        return true;
    }

    /**
     * Retorna o nome para o registro do tema na aplicação Laravel
     *
     * @return string
     */
    public function namespace($name) : string
    {
        return $this->getThemeNamespace($name);
    }

    /**
     * Verifica se um tema já existe com o nome específicado
     *
     * @param  $theme
     * @return boolean
     */
    public function exists(string $name) : bool
    {
        $dir  = $this->baseFolder();
        $path = $dir . DS . $name;

        return (is_dir($path));
    }

    /**
     * Retorna se já existe o diretório base para
     * o armazenamento de temas
     *
     * @return bool
     */
    public function existsBase() : bool
    {
        $base = $this->baseFolder();

        return (is_dir($base));
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param string $type
     * @return array
     */
    private function extract(string $theme, string $type) : array
    {
        $path = $this->path($theme);
        $dir  = $this->structure($type);

        $folders = scandir($path . DS .  $dir);
        $folders = array_splice($folders, 2);

        $itens = [];

        if (empty($folders)) return $itens;

        foreach($folders as $name) {
            $itens[] = $this->objectDirective($name, $theme, $type);
        }

        return $itens;
    }
}
