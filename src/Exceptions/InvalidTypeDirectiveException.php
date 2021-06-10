<?php

namespace Maestriam\Samurai\Exceptions;

use Maestriam\Samurai\Exceptions\BaseException;

class InvalidTypeDirectiveException extends BaseException
{
    const CODE = '0203';

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
        return 'The [%s] is a invalid type.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return self::CODE;
    }
}
