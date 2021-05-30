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
    
    /**
     * Retorna o tipo de diretiva 
     * 
     * @return string
     */
    public function type() : string;

    /**
     * Retorna o nome do arquivo
     *
     * @return string
     */
    public function filename() : string;
}