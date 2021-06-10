<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Foundation;

class Base extends Foundation
{
    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function any() : ?Theme
    {
        if ($this->empty()) {
            return null;
        }

        $current = $this->current();

        return $current ?? $this->first();
    }
    
    /**
     * {@inheritDoc}
     */
    public function empty() : bool
    {
        $dir = $this->readBase();

        return  (empty($dir)) ? true : false;
    }

    /**
     * Limpa o cache da aplicação Laravel
     *
     * @todo Pensar em um lugar melhor para deixar essa função. 
     * @return void
     */
    public function clean()
    {
        return $this->file()->clearCache();
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