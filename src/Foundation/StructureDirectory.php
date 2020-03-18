<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class StructureDirectory
{
    /**
     * Retorna o caminho 
     *
     * @return void
     */
    public function base()
    {
        $samurai = Config::get('Samurai.themes.folder');

        return $samurai;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function vendor()
    {
        $path = 'vendor'. DS .'maestriam';

        return base_path($path);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return string
     */
    public function theme(string $name) : ?string
    {
        $vendor = $this->vendor();
        $base   = $this->base();

        if ($this->findTheme($base, $name)) {
            return $this->findTheme($base, $name);
        }

        return $this->findTheme($vendor, $name); 
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function assets(string $name) : string
    {
        $assets = Config::get('Samurai.themes.assets');

        return $this->theme($name) . DS . $assets;
    }

    /**
     * Retorna o caminho público onde os assets
     * do tema são armazenados
     *
     * @param string $name
     * @return string
     */
    public function public(string $name) : string
    {
        return  public_path('themes'. DS . $name);
    }

    /**
     * Retorna o nome do diretório do projeto
     * Para receber o caminho completo, basta passar true em $path
     *
     * @param boolean $path
     * @return string
     */
    public function project(bool $path = false) : string
    {
        $dir = base_path();

        $pieces = explode(DS, $dir);

        return ($path == true ) ? $dir : end($pieces);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function files(string $name) : string
    {
        $files = Config::get('Samurai.themes.files');

        return $this->theme($name) . DS . $files;
    }

    /**
     * Retorna o caminho do diretório de um tema dado o nome 
     *
     * @param string $base
     * @param string $name
     * @return string|null
     */
    private function findTheme(string $base, string $name) : ?string
    {
        $name = strtolower($name);
        $path = $base . DS . $name;

        return (is_dir($path)) ? $path : null;
    }
}
