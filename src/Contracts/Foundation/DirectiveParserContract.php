<?php

namespace Maestriam\Samurai\Contracts\Foundation;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Includer;

interface DirectiveParserContract
{
    /**
     * Retorna as informações da diretiva em forma de objeto.  
     *
     * @return object
     */
    public function toObject() : object;

    /**
     * Retorna as informações da diretiva através uma instância de diretiva.  
     * Caso seja um component, entreguará um component.  
     * Caso contrário, entregará um includer.  
     *
     * @return Component|Includer
     */
    public function toDirective() : Component|Includer;
}