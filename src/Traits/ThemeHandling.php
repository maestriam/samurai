<?php

namespace Maestriam\Katana\Traits;

use Config;
use Maestriam\Katana\Handlers\ThemeHandler;

/**
 * Funções compartilhadas para manipulação de temas
 */
trait ThemeHandling
{
    /**
     * Retorna o caminho definido para os temas criados
     *
     * @return string
     */
    protected function getBaseThemeFolder() : string
    {
        return Config::get('Katana.themes.folder');
    }

    /**
     * Verifica se o diretório para armazenar os temas
     * foram criados de maneira correta
     *
     * @return boolean
     */
    protected function isBaseThemeFolder(): bool
    {
        $dir = $this->getBaseThemeFolder();

        return (is_dir($dir)) ? true : false;
    }

    /**
     * Retorna todos os temas criados dentro do
     * diretório principal do sistema
     *
     * @return array
     */
    public final function getAllThemes() : array
    {
        $dir = $this->getBaseThemeFolder();

        if (! is_dir($dir)) {
            return [];
        }

        $folders = scandir($dir);

        array_shift($folders);
        array_shift($folders);

        return $folders;
    }

    /**
     * Verifica se um tema já existe ou não
     * de acordo com um nome específicado
     *
     * @param  $theme
     * @return boolean
     */
    protected function themeExists($theme) : bool
    {
        $dir  = $this->getBaseThemeFolder();
        $path = $dir . DS . $theme;

        return (is_dir($path));
    }

    /**
     * Retorna uma instancia do serviço com todas as funções básicas
     * para manipular tema
     *
     * @return void
     */
    public final function theme()
    {
        return new ThemeHandler();
    }
}
