<?php

namespace Maestriam\Samurai\Handlers;

use Exception;
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
    public function component($theme, $name) : Directive
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
    public function include($theme, $name) : Directive
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
    public function create($theme, $name) : Directive
    {
        $mod  = $this->permission();
        $path = $this->path($theme, $name);

        mkdir($path, $mod, true);

        return $this->materialize($path, $name, $theme);
    }

    /**
     * Retorna o nível de permissão para criação da diretiva
     *
     * @return int
     */
    private function permission() : int
    {
        $permission = (int) Config::get('Samurai.permission');

        return (! $permission) ? 0755 : $permission;
    }

    /**
     * Verifica se o tipo de diretiva informada faz parte
     * do ecossistema do Blade
     *
     * @param string $directive
     * @return boolean
     */
    public function isValid(string $directive) : bool
    {
        $species = $this->types();

        return in_array($directive, $species);
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
    public function exists(string $theme, string $name) : bool
    {
        $dir = $this->path($theme, $this->type, $name);

        return (is_dir($dir)) ? true : false;
    }

    /**
     * Retorna a estrutura de pastas dentro do tema de acordo
     * com o tipo de diretiva selecionada (include/component)
     *
     * @param string $theme
     * @return array
     */
    public function folders(string $theme) : array
    {
        $path = $this->path($theme, $this->type);

        if (! is_dir($path)) return [];

        $scan = scandir($path);
        $dirs = array_splice($scan, 2);

        foreach ($dirs as $dir) {
            $folders[] = $path . $dir;
        }

        return $folders;
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
    private function path($theme, $name) : string
    {
        return $this->directivePath($theme, $name, $this->type);
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

        $file = $path .  DS  . $name . '-' .$this->type . '.php';

        $handle  = fopen($file, 'w');

        fwrite($handle, $content);
        fclose($handle);

        return $this->objectDirective($name, $theme, $file, $this->type);
    }
}
