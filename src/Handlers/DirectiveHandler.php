<?php

namespace Maestriam\Samurai\Handlers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\HandlerFunctions;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
use Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException;

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
            throw new InvalidTypeDirectiveException($type);
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
     * Verifica se o nome informado para a diretiva
     * segue os padrões corretos
     *
     * @return boolean
     */
    public function isValidName($name) : bool
    {
        $startNumbers   = "/^[\d]/";
        $onlyValidChars = "/^[a-zA-Z0-9]+$/";

        if (preg_match($startNumbers, $name)) {
            return false;
        }

        if (! preg_match($onlyValidChars, $name)) {
            return false;
        }

        return true;
    }

    /**
     * Verifica se a já existe uma diretiva com determinado nome
     * em um tema específico
     *
     * @param string $theme
     * @param string $name
     * @param string $type
     * @param string $sub
     * @return boolean
     */
    public function exists(string $theme, string $name, $sub = null) : bool
    {
        $dir = $this->path($theme, $name, $sub);

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
     *  Cria uma nova diretiva dentro de um tema específico
     *
     * @param string $theme
     * @param string $name
     * @param string $type
     * @return Directive
     */
    private function create($theme, $filename) : ?Directive
    {
        if (! $this->themeExists($theme)) {
            throw new ThemeNotFoundException($theme);
        }

        list($sub, $name) = $this->separate($filename);

        if (! $this->isValidName($name)) {
            throw new InvalidDirectiveNameException($name);
        }

        if ($this->exists($theme, $name, $sub)) {
            throw new DirectiveExistsException($theme, $name);
        }

        $path = $this->path($theme, $name, $sub);

        mkdir($path, $this->permission(), true);

        return $this->materialize($theme, $name, $path, $sub);
    }


    /**
     * Separa o nome do componente da sub-pasta indicada
     * pelo usuário
     *
     * @param string $file
     * @return array
     */
    private function separate(string $file) : array
    {
        $pieces = explode('/', $file);

        $name  = array_pop($pieces);
        $place = implode(DS, $pieces);

        return [$place, $name];
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
    private function path(string $theme, string $name, $place = null) : string
    {
        return $this->directivePath($theme, $name, $place);
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
    private function materialize($theme, $name, $path, $sub = null) : Directive
    {
        $content = $this->stub($this->type, $name);
        $file    = $this->directiveFileName($path, $name, $this->type);
        $handle  = fopen($file, 'w');

        fwrite($handle, $content);
        fclose($handle);

        return $this->objectDirective($name, $theme, $this->type, $sub);
    }
}
