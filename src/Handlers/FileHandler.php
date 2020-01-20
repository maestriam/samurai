<?php

namespace Maestriam\Samurai\Handlers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

class FileHandler
{
    private $type;

    /**
     * Define o tipo de diretiva que será manipulado
     *
     * @param string $type
     * @return void
     */
    public function define($type)
    {
        $this->type = $type;

        return $this;
    }


    /**
     * Verifica todas as premissas para se criar uma nova diretiva
     * dentro de um tema específico
     *
     * @param string $type
     * @param string $theme
     * @param string $name
     * @return void
     */
    public function create($theme, $name, $type = null)
    {
        $path = $this->path($theme, $type, $name);
        $perm = $this->getPermissionLevel();

        mkdir($path, $perm, true);

        $this->materialize($type, $path, $name);
    }



    /**
     * Retorna o caminho completo da diretiva
     *
     * @param string $theme
     * @param string $name
     * @return string
     */
    public function path(string $theme, string $type, string $name = null) : string
    {
        $name   = strtolower($name);
        $type   = strtolower($type);
        $theme  = strtolower($theme);

        $key    = 'themes.structure.' . $type;
        $folder = $this->getThemeConfig('themes.folder');
        $dir    = $this->getThemeConfig($key);

        return $folder . DS . $theme . DS . $dir . $name;
    }

    /**
     * Identifica que tipo de diretiva que se trata o arquivo
     * e retorna seu tipo
     *
     * @param $file
     * @return void
     */
    public function identify($file)
    {
        $name = explode('-', $file);

        if (empty($name)) return null;

        $type = explode('.', $name[1]);

        if (empty($type) || ! $this->isValid($type[0])) return null;

        $obj = ['type' => $type[0], 'name' => $name[0]];

        return (object) $obj;
    }


    /**
     * Verifica o tipo de diretiva informada e faz sua importação
     * para ser usada dentro das views do Blade
     *
     * @param string $alias
     * @param string $file
     * @return void
     */
    public function import(string $alias, string $file)
    {
        $directive = $this->identify($file);

        if (! $directive) {
            return null;
        }

        $path = $this->bladePath($alias, $directive->type, $directive->name);

        if ($directive->type == 'component') {
            return Blade::component($path, $directive->name);
        }

        return Blade::include($path, $directive->name);
    }


}
