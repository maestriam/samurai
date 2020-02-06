<?php

namespace Maestriam\Samurai\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;

class DirectiveExistsException extends Exception
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $theme, string $name)
    {
        $this->setMessage($theme, $name);
        $this->setCode('0203');
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

    /**
     * Define qual será o número do código de retorno
     *
     * @param integer $code
     * @return void
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }
}
