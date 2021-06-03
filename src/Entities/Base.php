<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\FileSystem\Support\FileSystem as SupportFileSystem;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Foundation;
use Maestriam\Samurai\Foundation\FileSystem;

class Base extends Foundation
{
    /**
     * Retorna todos os temas cadastrados no projeto
     *
     * @return array
     */
    public function all() : array
    {
        $themes  = [];
        $folders = $this->readBase();

        if (empty($folders)) {
            return $themes;
        }

        foreach($folders as $folder) {

            $theme = $this->themefy($folder);

            if ($theme == null) continue;

            $themes[] = $theme;
        }

        return $themes;
    }

    /**
     * Retorna o primeiro tema cadastrado no projeto
     *
     * @return Theme|null
     */
    public function first() : ?Theme
    {
        $vendors = $this->readBase();

        if (empty($vendors)) {
            return null;
        }

        $vendor = array_shift($vendors);
        $themes = $this->readVendor($vendor);
        
        if (empty($themes)) {
            return null;
        }

        $theme = array_shift($themes);
        $name  = $vendor . '/' . $theme;

        return $this->themefy($name);
    }

    /**
     * Retorna o tema atual selecionado
     *
     * @return Theme|null
     */
    public function current() : ?Theme
    {
        $key  = $this->config()->env();
        $name = $this->env()->get($key);

        if ($name != null) {
            return $this->themefy($name);
        }

        $first = $this->first();

        if ($first != null) {
            return $first;
        }

        return null;
    }
    
    /**
     * Limpa o cache dos arquivos de view do projeto
     *
     * @return void
     */
    public function clearCache()
    {
        return $this->file()->clearCache();
    }
}



    // /**
    //  * Retorna o objeto de um tema de acordo com um nome específico
    //  *
    //  * @param string $name
    //  * @return Theme
    //  */
    // private function themefy(string $name) : ?Theme
    // {
    //     $theme = new Theme($name);

    //     return $theme->get();
    // }

    // /**
    //  * Retorna a lista de todos as pastas criadas dentro
    //  * da base de temas do projeto
    //  *
    //  * @return void
    //  */
    // private function readBase() : array
    // {
    //     $base = $this->config()->base();
        
    //     return SupportFileSystem::folder($base)->read(2);
    // }
    
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