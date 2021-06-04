<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Author;
use Maestriam\Samurai\Entities\Structure;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Vendor;

interface BaseContract
{
    /**
     * Retorna todos os temas cadastrados no projeto
     *
     * @return array
     */
    public function all() : array;

    /**
     * Retorna o tema padrão definido no projeto.  
     *
     * @return Theme|null
     */
    public function current() : ?Theme;

    /**
     * Retorna o primeiro tema que encontrar no projeto, se exisit.  
     *
     * @return ?Theme
     */
    public function first() : ?Theme;

    /**
     * Tenta retornar qualquer tema na base.  
     * Se não tiver vazio, tenta retornar o tema atual.  
     * Se não tiver atual, retorna o primeiro que encontrar.  
     *
     * @return Theme|null
     */
    public function any() : ?Theme;

    /**
     * Retorna se o diretório-base de temas está vazio ou não.  
     *
     * @return boolean
     */
    public function empty() : bool;
}