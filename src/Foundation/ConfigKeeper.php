<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class ConfigKeeper
{
    /**
     * Retorna o nome da chave que será aplicada no arquivo .env.
     * Se não conseguir encontrar a chave no arquivo de configuração
     * do pacote, retorne THEME_CURRENT.
     *
     * @return string
     */
    public function env() : string
    {
        return Config::get('samurai.env_key', 'THEME_CURRENT');
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

    /**
     * Retorna o texto da descrição para a criação de um novo tema
     *
     * @return string
     */
    public function description() : string
    {
        return Config::get('Samurai.description');
    }

}
