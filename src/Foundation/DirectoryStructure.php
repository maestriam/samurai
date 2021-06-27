<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class DirectoryStructure
{
    private ConfigKeeper $configInstance;

    public function __construct()
    {
        $this->setConfig();
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
     * Retorna o caminho do tema dentro do diretório-base
     * de temas ou dentro do diretório do composer
     *
     * @param string $name
     * @return string
     */
    public function theme(string $vendor, string $name) : ?string
    {
        $base = $this->config()->base();

        // $finded = $this->findVendor($vendor, $name);

        // if ($finded) return $finded;

        return $this->findTheme($base, $vendor, $name);
    }

    /**
     * Retorna o caminho relativo de um tema/diretiva
     * dentro do projeto
     *
     * @return void
     */
    public function indicative(string $path) : string
    {
        $base = base_path() . DS; 

        return str_replace($base, '', $path);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function assets(string $vendor, string $name) : string
    {
        $assets = config('samurai.themes.assets');

        return $this->theme($vendor, $name) . DS . $assets;
    }

    /**
     * Retorna o caminho público onde os assets
     * do tema são armazenados
     *
     * @param string $name
     * @return string
     */
    public function public(string $vendor, string $name) : string
    {
        return  public_path('themes'. DS . $vendor . DS . $name);
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
        $files = config('samurai.themes.files');

        return $this->theme($vendor, $name) . DS . $files . DS;
    }

    /**
     * Undocumented function
     *
     * @param string $vendor
     * @param string $name
     * @return string|null
     */
    private function findVendor(string $vendor, string $name) : ?string
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
        
        $path = $base . $vendor . DS . $name;

        return $path;
    }

    /**
     * Retorna a instância de configurações do arquivo.  
     *
     * @return ConfigKeeper
     */
    private function config() : ConfigKeeper
    {
        return $this->configInstance;
    }
    
    /**
     * Define a instância de configurações do arquivo.  
     *
     * @return DirectoryStructure
     */
    private function setConfig() : DirectoryStructure
    {
        $this->configInstance = new ConfigKeeper();
        
        return $this;
    }
}
