<?php

namespace Maestriam\Samurai\Handlers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\HandlerFunctions;

class DirectiveHandler
{
    use HandlerFunctions;

    /**
     * Tipo do componente que será criado/manipulado
     *
     * @var string
     */
    private $type = '';

    /**
     * Define o tipo de componente que será manipulado para criação
     *
     * @param string $type
     * @return DirectiveHanlder
     */
    public function define($type) : DirectiveHandler
    {
        if ($type == null) {
            throw new Exception('Não é possível encontrar o tipo', 1);
        }

        if (! $this->isValid($type)) {
            throw new Exception('Tipo de diretiva inválida');
        }

        $this->type = strtolower($type);
        return $this;
    }

    /**
     * Cria uma diretiva de component dentro de um tema
     *
     * @param string $theme
     * @param string $name
     * @return Directive
     */
    public function component($theme, $name) : ?Directive
    {
        $this->define('component');

        return $this->create($theme, $name);
    }

    /**
     * Cria uma diretiva de include dentro de um tema
     *
     * @param string $theme
     * @param string $name
     * @return Directive
     */
    public function include($theme, $name) : ?Directive
    {
        $this->define('include');

        return $this->create($theme, $name);
    }

    /**
     *  Cria uma nova diretiva dentro de um tema específico
     *
     * @param string $theme
     * @param string $name
     * @param string $type
     * @return Directive
     */
    public function create($theme, $name) : ?Directive
    {
        if (! $this->isValidName($name)) {
            return null;
        }

        if ($this->exists($theme, $name)) {
            return $this->objectDirective($name, $theme, $this->type);
        }

        $mod  = $this->permission();
        $path = $this->path($theme, $name);

        mkdir($path, $mod, true);

        return $this->materialize($path, $name, $theme);
    }

    /**
     * Verifica se o tipo de diretiva informada faz parte
     * do ecossistema do Blade
     *
     * @param string $type
     * @return boolean
     */
    public function isValid(string $type) : bool
    {
        return $this->isValidDirectiveType($type);
    }

    /**
     * Verifica se a já existe uma diretiva com determinado nome
     * em um tema específico
     *
     * @param string $type
     * @param string $theme
     * @param string $name
     * @return boolean
     */
    public function exists(string $theme, string $name, string $type = null) : bool
    {
        if ($type == null) {
            $type = $this->type;
        }

        $dir = $this->path($theme, $name, $type);

        return (is_dir($dir)) ? true : false;
    }

    /**
     * Carrega a diretiva para ser usada dentro do projeto
     *
     * @param Directive $directive
     * @return boolean
     */
    public function load(Directive $obj) : bool
    {
        if (! file_exists($obj->path)) {
            return false;
        }

        $path = $this->getBladePathDirective($obj);

        if ($obj->type == 'include') {
            return $this->loadInclude($path, $obj->name);
        }

        return $this->loadComponent($path, $obj->name);
    }

    /**
     * Importa um include para ser usado no projeto
     *
     * @param string $path
     * @param string $name
     * @return bool
     */
    private function loadInclude($path, $name) : bool
    {
        Blade::include($path, $name);
        return true;
    }

    /**
     * Importa um component para ser usado no projeto
     *
     * @param string $path
     * @param string $name
     * @return bool
     */
    private function loadComponent($path, $name) : bool
    {
        Blade::component($path, $name);
        return true;
    }

    /**
     * Retorna o conteúdo do arquivo de base para criação
     * de components e includes
     *
     * @param string $type
     * @param string $placeholder
     * @return string
     */
    private function stub($type, $placeholder) : string
    {
        $path = __DIR__ . DS .  "../Stubs/{$type}.stub";
        $stub = file_get_contents($path);

        return str_replace('{{name}}', $placeholder, $stub);
    }

    /**
     * Retorna o caminho completo da diretiva
     *
     * @param string $theme
     * @param string $name
     * @return string
     */
    private function path($theme, $name, $type = null) : string
    {
        if ($type == null) {
            $type = $this->type;
        }

        return $this->directivePath($theme, $name, $type);
    }

    /**
     * Cria um arquivo de view do Blade para ser criado um novo
     * componente ou include
     *
     * @param string $path
     * @param string $name
     * @param string $theme
     * @return Directive
     */
    private function materialize($path, $name, $theme) : Directive
    {
        $content = $this->stub($this->type, $name);
        $file    = $this->directiveFileName($path, $name, $this->type);
        $handle  = fopen($file, 'w');

        fwrite($handle, $content);
        fclose($handle);

        return $this->objectDirective($name, $theme, $this->type);
    }
}
