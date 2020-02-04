<?php

namespace Maestriam\Samurai\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;

class InvalidThemeNameException extends Exception
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setMessage($name);
        $this->setCode(0101);
    }

    /**
     * Define a mensagem de texto que será enviado para o cliente
     *
     * @param string $name
     * @return void
     */
    public function setMessage(string $name)
    {
        $key = 'Samurai::exceptions.theme.invalid-name';

        $this->message = Lang::get($key, ['name' => $name]);
    }

    /**
     * Define qual será o número do código de retorno
     *
     * @param integer $code
     * @return void
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }
}
