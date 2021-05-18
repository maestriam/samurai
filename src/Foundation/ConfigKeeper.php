<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class ConfigKeeper
{
    /**
     * Retorna o nome da chave que será aplicada no arquivo .env.
     * Se não conseguir encontrar a chave no arquivo de configuração
     * do pacote, retorne CURRENT_THEME.
     *
     * @return string
     */
    public function env() : string
    {
        return config('samurai.env_key') ?? 'CURRENT_THEME';
    }

    /**
     * Retorna as configurações do autor para criação de um tema
     *
     * @return object
     */
    public function author() : object
    {
        $author = Config::get('samurai.author');

        return (object) $author;
    }

    /**
     * Retorna o texto da descrição para a criação de um novo tema
     *
     * @return string
     */
    public function description() : string
    {
        $default = 'A new awsome theme is comming!';

        return config('samurai.description') ?? $default;
    }    
}
