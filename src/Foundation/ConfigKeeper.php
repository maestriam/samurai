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
     * Retorna o caminho-base dos temas dentro do projeto
     *
     * @return void
     */
    public function base() : string
    {
        $default = base_path('themes');

        return config('samurai.themes.folder') ?? $default;
    }

    /**
     * Retorna as configurações do autor para criação de um tema
     *
     * @return object
     */
    public function author() : object
    {
        $author = config('samurai.author');

        return (object) $author;
    }

    public function dist() : string
    {
        return config('samurai.author.dist') ?? 'maestriam';
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
    
    /**
     * Retorna o caminho do diretório onde está armazenado os 
     * arquivos de template
     *
     * @return string
     */
    public function template() : string
    {
        return config('samurai.template_path');
    }

    /**
     * Retorna a relação de tipos de templates com o caminho
     * onde ele deve ser inserido no diretório
     *
     * @return array
     */
    public function structure() : array
    {
        return config('samurai.structure');
    }
}
