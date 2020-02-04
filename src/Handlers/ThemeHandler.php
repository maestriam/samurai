<?php

namespace Maestriam\Samurai\Handlers;

use Maestriam\Samurai\Models\Theme;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Maestriam\Samurai\Traits\HandlerFunctions;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

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
     * de acordo com o nome específicado
     *
     * @return Theme
     */
    public function get(string $name) : ?Theme
    {
        if (! $this->exists($name)) {
            return null;
        }

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
        $themes = $this->readBase();

        if (empty($themes)) {
            return [];
        }

        $collection = [];

        foreach ($themes as $theme) {
            $collection[] = $this->objectTheme($theme);
        }

        return $collection;
    }

    /**
     * Retorna o primeiro tema encontrado no projeto
     *
     * @return Theme
     */
    public function first() : ?Theme
    {
        $themes = $this->readBase();

        if (empty($themes)) return null;

        $first = $themes[0];

        return $this->objectTheme($first);
    }

    /**
     * Retorna uma lista de todas as diretivas de um determinado tema
     *
     * @param string $name
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
     * Verifica se o nome informado para o tema
     * segue os padrões corretos
     *
     * @return boolean
     */
    public final function isValidName($name) : bool
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
     * Cria um novo diretório de tema
     *
     * @param string $name
     * @return void
     */
    public function create($name) : ?Theme
    {
        if (! $this->isValidName($name)) {
            throw new InvalidThemeNameException($name);
        }

        if ($this->exists($name)) {
            return $this->objectTheme($name);
        }

        if (! $this->existsBase()) {
            $this->makeBase();
        }

        $path = $this->path($name);

        $this->mkFolder($path);
        $this->subFolders($path);

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
        return $this->themeExists($name);
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
     * @return void
     */
    public function publish(string $name) : bool
    {
        $theme = $this->get($name);
        $dist  = Config::get('Samurai.publishable');

        if ($theme == null) {
            throw new ThemeNotFoundException($name);
        }

        $origin = $theme->path . DS . $dist;
        $destination = public_path('themes/'. $theme->name);

        File::copyDirectory($origin, $destination);

        return (is_dir($destination)) ? true : false;
    }

    /**
     * Retorna o conteúdo de TODOS os temas
     * dentro do diretório base
     *
     * @return array
     */
    private function readBase() : array
    {
        $base = $this->baseFolder();

        if (! $this->existsBase($base)) {
            return [];
        }

        $themes = scandir($base);
        $themes = array_splice($themes, 2);

        return empty($themes) ?  [] : $themes;
    }

    /**
     * Extrai TODOS as diretivas registradas em um tema
     * especificando por tipo
     *
     * @param string $name
     * @param string $type
     * @return array
     */
    private function extract(string $theme, string $type) : array
    {
        $itens = [];
        $path  = $this->path($theme);
        $dir   = $this->structure($type);

        $directive = $path . DS .  $dir;

        if (! is_dir($directive)) return $itens;

        $folders = scandir($directive);
        $folders = array_splice($folders, 2);

        if (empty($folders)) return $itens;

        foreach($folders as $name) {
            $itens[] = $this->objectDirective($name, $theme, $type);
        }

        return $itens;
    }

    /**
     * Cria a estrutura de sub-diretórios do tema
     *
     * @param string $themePath
     * @return void
     */
    private function subFolders($themePath)
    {
        $structure = $this->structure();

        foreach ($structure as $type => $folder) {

            $subfolder = str_replace('/', DS, $folder);
            $subfolder = $themePath . DS . $subfolder;

            $this->mkFolder($subfolder);
        }
    }

    /**
     * Cria um novo diretório com as configurações
     * fornecidas no arquivo de configuração
     *
     * @param string $path
     * @return int
     */
    private function mkFolder(string $path) : bool
    {
        return mkdir($path, $this->permission(), true);
    }
}
