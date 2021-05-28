<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Composer;
use Maestriam\Samurai\Entities\Vendor;

interface ComposerContract
{
    public function __construct(Vendor $vendor, string $desc = null);

    /**
     * Retorna/Define a descrição do tema 
     * Se passar uma string como parâmetro, assume a função de definição
     *
     * @param string $desc
     * @return string|Composer
     */
    public function description(string $desc = null) : string|Composer
}