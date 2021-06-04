<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Entities\Theme;

interface SamuraiContract
{
    /**
     * Retorna a instância para operaçãoes sobre o diretório-base
     * dos temas cadastrados no projeto.  
     *
     * @return Base
     */
    public function base() : Base;

    /**
     * Retorna a instância para operaçãoes para manipulação de temas
     * dentro do projeto.  
     *
     * @return Theme
     */
    public function theme(string $package) : Theme;
}