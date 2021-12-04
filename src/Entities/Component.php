<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Entities\Directive;

class Component extends Directive
{    
    /**
     * Tipo da diretiva
     */
    protected string $type = 'component';

    /**
     * Nome do template
     */
    protected string $template = 'component';
}
