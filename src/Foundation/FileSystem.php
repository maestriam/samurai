<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class FileSystem
{
    /**
     * Retorna o nível de permissão para criação da diretiva
     *
     * @return int
     */
    public function permission() : int
    {
        $permission = (int) Config::get('Samurai.permission');

        return (! $permission) ? 0755 : $permission;
    }

    /**
     * Cria um novo diretório com as configurações
     * fornecidas no arquivo de configuração
     *
     * @param string $path
     * @return int
     */
    public function mkFolder(string $path) : bool
    {
        return mkdir($path, $this->permission(), true);
    }

    /**
     * Undocumented function
     *
     * @param string $filename
     * @return boolean
     */
    public function mkFile(string $filename, string $content) : bool
    {

    }
}
