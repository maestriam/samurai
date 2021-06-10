<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class ThemeExistsException extends BaseException
{
    const CODE = '0103';

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
        return 'The theme [%s] alredy exists on project.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return self::CODE;
    }
}
