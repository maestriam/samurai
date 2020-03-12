<?php

namespace Maestriam\Samurai\Foundation;

use Str;
use Illuminate\Support\Facades\Config;

class FileNominator
{
    /**
     * Retorna o nome da diretiva para ser usado
     * como nome de arquivo
     *
     * @param string $name
     * @param string $type
     * @return string
     */
    public function directive(string $name, string $type) : string
    {
        return $name . '-' .$type;
    }

    /**
     * Retorna
     *
     * @param [type] $theme
     * @return string
     */
    public function namespace($theme) : string
    {
        $prefix = Config::get('Samurai.prefix');

        return $prefix . '-' . $theme;
    }

    /**
     * Retorna
     *
     * @param string $name
     * @param string $type
     * @return void
     */
    public function filename(string $name, string $type)
    {
        return $this->directive($name, $type) . '.blade.php';
    }

    /**
     * Retorna o nome para o ser chamado dentro do
     *
     * @param string $theme
     * @param string $path
     * @return void
     */
    public function blade(string $theme, string $path)
    {
        $pattern = "%s::%s";
        $ext = '.blade.php';

        $file = sprintf($pattern, $theme, $path);
        $file = str_replace(DS, '.', $file);
        $file = str_replace($ext, '', $file);

        return $file;
    }

    /**
     * Retorna o nome para ser chamado dentro do arquivo Blade
     *
     * @param string $name
     * @return string
     */
    public function alias(string $name) : string
    {
        return Str::camel($name);
    } 
}
