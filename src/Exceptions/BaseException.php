<?php

namespace Maestriam\Samurai\Exceptions;

use Exception;

class BaseException extends Exception
{
    /**
     * Inicia os atributos de acordo com o código de erro
     *
     * @param string $code
     * @return void
     */
    public function initialize(string $code, string $message, string ...$params)
    {
        $this->setCode($code);
        $this->setMessage($message, $params);
    }

    /**
     * Define qual será o número do código de retorno
     *
     * @param integer $code
     * @return void
     */
    protected function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * Define a mensagem de texto que será enviado para o cliente
     *
     * @param string $theme
     * @param string $name
     * @return void
     */
    protected function setMessage(string $message, array $params = [])
    {
        $this->message = vsprintf($message, $params);
    }
}
