<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class InvalidComposerFileException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $theme)
    {
        $msg = 'Composer file is not valid in theme [%s].';
        
        $this->initialize(0103, $msg, $theme);
    }
}
