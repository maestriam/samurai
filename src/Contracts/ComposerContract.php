<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Composer;

interface ComposerContract
{
    /**
     * Instância com as regras de negócio sobre composer.json
     *
     * @param Vendor $vendor
     * @param string $desc
     */
    public function __construct(Theme $theme, string $desc = null);

    /**
     * Retorna/Define a descrição do tema 
     * Se passar uma string como parâmetro, assume a função de definição
     *
     * @param string $desc
     * @return string|Composer
     */
    public function description(string $desc = null) : string|Composer;
}