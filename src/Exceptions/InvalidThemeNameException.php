<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class InvalidThemeNameException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setCode(INVALID_THEME_NAME_CODE);
        $this->setMessage(INVALID_THEME_NAME_CODE, $name);
    }
}
