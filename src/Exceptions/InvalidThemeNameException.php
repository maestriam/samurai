<?php

namespace Maestriam\Samurai\Exceptions;

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
        $this->initialize($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage() : string
    {
        return 'The name [%s] is an invalid. Its not possible to create an theme with special characters and start number.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return 0101;
    }
}
