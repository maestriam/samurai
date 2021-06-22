<?php

namespace Maestriam\Samurai\Contracts\Entities;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Wizard;

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

    /**
     * Retorna a instância para auxiliar o cliente a criar um tema
     * via console. 
     *
     * @return Wizard
     */
    public function wizard() : Wizard;
}