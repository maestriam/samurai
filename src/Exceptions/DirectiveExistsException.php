<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class DirectiveExistsException extends BaseException
{
    const CODE = '0202';

    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $theme, string $name)
    {
        $this->initialize($theme, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage(): string
    {
        return 'The [%s] directive alredy exists in [%s] theme.';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode(): string
    {
        return self::CODE;
    }
}
