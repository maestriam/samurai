<?php

namespace Maestriam\Samurai\Traits;

use Maestriam\Samurai\Models\Theme;

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
    public final function theme(string $name)
    {
        return new Theme($name);
    }
}
