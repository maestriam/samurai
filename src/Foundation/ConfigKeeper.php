<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class ConfigKeeper
{
    public function env()
    {
        return Config::get('Samurai.env_key');
    }

    /**
     * Retorna as configurações do autor para criação de um tema
     *
     * @return object
     */
    public function author() : object
    {
        $author = Config::get('Samurai.author');

        return (object) $author;
    }
    
}
