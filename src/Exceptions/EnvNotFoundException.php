<?php

namespace Maestriam\Samurai\Exceptions;

use Maestriam\Samurai\Exceptions\BaseException;

class EnvNotFoundException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage(): string
    {
        return 'File .env not found.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode(): string
    {
        return 0301;
    }
}

