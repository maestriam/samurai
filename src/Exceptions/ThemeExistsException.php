<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class ThemeExistsException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $theme)
    {
        $msg = 'The theme "%s" alredy exists on project.';
        
        $this->initialize(0103, $msg, $theme);
    }
}
