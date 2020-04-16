<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class DirectiveExistsException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $theme, string $name)
    {
        $this->initialize(DIRECTIVE_EXISTS_CODE, $name, $theme);
    }
}
