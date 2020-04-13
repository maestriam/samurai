<?php

namespace Maestriam\Samurai\Traits;

use Maestriam\Samurai\Models\Base;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Wizard;

/**
 * Funções compartilhadas para manipulação de temas
 */
trait Themeable
{
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

    /**
     *
     *
     * @return Base
     */
    public final function base() : Base
    {
        return new Base();
    }


    public final function wizard() : Wizard
    {
        return new Wizard();
    }
}
