<?php

namespace Maestriam\Katana\Traits;

use Config;

trait BasicConfig
{
    /**
     * Apelido para chamada de configurção do pacote
     *
     * @var string
     */
    protected $configAlias = 'Katana';

    /**
     * Nome-base do comando que será utilizado para comandos Artisan
     *
     * @var string
     */
    protected $commandAlias = 'katana';

    /**
     * Nível de permissão para criação das pastas dos temas
     *
     * @var string
     */
    protected $permissionLevel = 0755;

    /**
     * Retorna as configurações gerais do pacote de temas
     *
     * @return void
     */
    protected function getThemeConfig($key = null)
    {
        $alias = $this->configAlias . '.' . $key;

        return Config::get($alias);
    }

    /**
     * Retorna o nível de permissão para criação de pastas dos temas
     *
     * @return int
     */
    protected function getPermissionLevel() : int
    {
        return (int) $this->permissionLevel;
    }
}
