<?php

namespace Maestriam\Samurai\Entities;

class Includer extends Directive
{
    /**
     * Nome do template
     */
    protected string $template = 'include';

    /**
     * Tipo da diretiva tratada
     */
    protected string $type = 'include';   
}
