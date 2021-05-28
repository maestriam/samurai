<?php

namespace Maestriam\Samurai\Contracts;

interface DirectiveContract
{
    /**
     * Retorna a sentença definida pelo usuário para manipulação 
     * de uma diretiva
     *
     * @return string
     */
    public function sentence() : string;
}