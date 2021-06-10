<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class ThemeNotFoundException extends BaseException
{
    const CODE = '0102';

    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->initialize( $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage() : string
    {
        return 'Theme [%s] not found. Check the theme name and try again.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return self::CODE;
    }
}
