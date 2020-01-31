<?php

namespace Maestriam\Samurai\Traits;

use Maestriam\Samurai\Handlers\EnvFileHandler;

/**
 * Funções compartilhadas para manipulação de temas
 */
trait EnvHandling
{
    protected static $themeHanlder;

    /**
     * Retorna uma instancia do serviço com todas as funções básicas
     * para manipular tema
     *
     * @return void
     */
    public final function env()
    {
        return isset(static::$themeHanlder)
            ? static::$themeHanlder
            : static::$themeHanlder = new EnvFileHandler();
    }
}
