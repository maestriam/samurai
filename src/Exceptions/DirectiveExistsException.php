<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class DirectiveExistsException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $theme, string $name)
    {
        $this->setMessage($theme, $name);
        $this->setCode(DIRECTIVE_EXISTS_CODE);
    }

    /**
     * Define a mensagem de texto que será enviado para o cliente
     *
     * @param string $theme
     * @param string $name
     * @return void
     */
    public function setMessage(string $theme, string $name)
    {
        $key = 'Samurai::exceptions.directive.exists';

        $placeholders = ['name' => $name, 'theme' => $theme];

        $this->message = Lang::get($key, $placeholders);
    }
}
