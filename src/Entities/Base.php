<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Foundation;

class Base extends Foundation
{
    /**
     * Retorna todos os temas cadastrados no projeto
     *
     * @return array
     */
    public function all() : array
    {
        $themes = [];

        foreach($this->readBase() as $folder) {

            $theme = $this->find($folder);

            if ($theme == null) {
                continue;    
            }

            $themes[] = $theme;
        }

        return $themes;
    }

    /**
     * Retorna o tema padrão definido no projeto.  
     *
     * @return Theme|null
     */
    public function current() : ?Theme
    {
        $key = $this->config()->env();

        $current = $this->env()->get($key);

        if (! $current) {
            return null;
        }

        return $this->find($current);
    }

    /**
     * Retorna o primeiro tema que encontrar no projeto, se exisit.  
     *
     * @return ?Theme
     */
    public function first() : ?Theme
    {
        $folders = $this->readBase();
        
        if (empty($folders)) {
            return null;
        }
        
        $first = array_shift($folders);
        
        return $this->find($first);
    }

    /**
     * Retorna a instância de um tema.  
     * Se o tema não existir no projeto, retorna nulo.  
     *
     * @param string $package
     * @return Theme|null
     */
    private function find(string $package) : ?Theme
    {
        $theme = new Theme($package);

        return $theme->find();
    }

    /**
     * Retorna a lista de temas cadastrados no projeto
     *
     * @return array
     */
    private function readBase() : array
    {
        $path = $this->config()->base();

        return FileSystem::folder($path)->read(2);
    }
}
    
    // /**
    //  * Retorna a lista de todos as pastas criadas dentro
    //  * da base de temas do projeto
    //  *
    //  * @param string $vendor
    //  * @return void
    //  */
    // private function readVendor(string $vendor) : array
    // {
    //     $base = $this->dir()->base() . $vendor;

    //     return $this->file()->readDir($base);
    // }


    
    // /**
    //  * Limpa o cache dos arquivos de view do projeto
    //  *
    //  * @return void
    //  */
    // public function clearCache()
    // {
    //     return $this->file()->clearCache();
    // }