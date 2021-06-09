<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class InvalidDirectiveNameException extends BaseException
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
        return 'The [%s] is an invalid name. Its not possible to create an directive with special characters and start number.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return 0201;
    }
}
