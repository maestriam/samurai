<?php

namespace Maestriam\Samurai\Exceptions;

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
        $this->initialize($theme);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage() : string
    {
        return 'Composer file is not valid in theme [%s].';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return 0501;
    }
}
