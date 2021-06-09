<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class StubNotFoundException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->initialize($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage() : string
    {
        return 'The stub file [%s] required is not found.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return 0401;
    }
}
