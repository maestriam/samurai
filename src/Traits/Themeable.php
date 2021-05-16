<?php

namespace Maestriam\Samurai\Traits;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Entities\Theme;
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
    public final function theme(string $name) : Theme
    {
        return new Theme($name);
    }

    /**
     * Retorna uma instância do serviço com todas as funções básicas
     * para manipular a base de temas dentro do projeto
     *
     * @return Base
     */
    public final function base() : Base
    {
        return new Base();
    }


    /**
     * Retorna uma instância do serviço com todas os questionários
     * para guiar o usuário e criar um tema corretamente
     *
     * @return Base
     */
    public final function wizard() : Wizard
    {
        return new Wizard();
    }
}
