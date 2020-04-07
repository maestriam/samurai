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
    public function base() : string
    {
        $samurai = Config::get('Samurai.themes.folder');

        return $samurai;
    }

    /**
     * Retorna o nome do diretório do
     *
     * @return void
     */
    public function vendor() : string
    {
        return base_path('vendor');
    }

    /**
     * Retorna o caminho do diretório dentro do diretório-base
     * de temas ou dentro do diretório do composer
     *
     * @param string $name
     * @return string
     */
    public function theme(string $vendor, string $name) : ?string
    {
        $base   = $this->base();
        $finded = $this->findVendor($vendor, $name);

        if ($finded) return $finded;

        return $this->findTheme($base, $vendor, $name);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function assets(string $vendor, string $name) : string
    {
        $assets = Config::get('Samurai.themes.assets');

        return $this->theme($vendor, $name) . DS . $assets;
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
    public function files(string $vendor, string $name) : string
    {
        $files = Config::get('Samurai.themes.files');

        return $this->theme($vendor, $name) . DS . $files;
    }

    /**
     * Undocumented function
     *
     * @param string $vendor
     * @param string $name
     * @return string|null
     */
    private final function findVendor(string $vendor, string $name) : ?string
    {
        $base = $this->vendor();

        $path = $this->findTheme($base, $vendor, $name);

        return (is_dir($path)) ? $path : null;
    }

    /**
     * Retorna o caminho do diretório de um tema dado o nome
     *
     * @param string $base
     * @param string $name
     * @return string|null
     */
    private function findTheme(string $base, string $vendor, string $name) : string
    {
        $name = strtolower($name);
        $path = $base . DS . $vendor . DS . $name;

        return $path;
    }
}
