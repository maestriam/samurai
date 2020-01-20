<?php

namespace Maestriam\Samurai\Traits;

use Config;
use Maestriam\Samurai\Handlers\ThemeHandler;

/**
 * Funções compartilhadas para manipulação de temas
 */
trait ThemeHandling
{
    protected static $themeHanlder;

    /**
     * Retorna uma instancia do serviço com todas as funções básicas
     * para manipular tema
     *
     * @return void
     */
    public final function theme()
    {
        return isset(static::$themeHanlder)
            ? static::$themeHanlder
            : static::$themeHanlder = new ThemeHandler();
    }
}
