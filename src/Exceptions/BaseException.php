<?php

namespace Maestriam\Samurai\Exceptions;

use Config;
use Exception;

class BaseException extends Exception
{
    /**
     * Inicia os atributos de acordo com o código de erro
     *
     * @param string $code
     * @return void
     */
    public function initialize(string $code)
    {
        $this->setCode($code);
        $this->setMessage($code);
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
    protected function setMessage(string $code, string ...$placeholders)
    {
        $consts  = Config::get('Samurai.errors');
        $text    = $consts[$code]['msg'];
        $message = $text;

        foreach ($placeholders as $placeholder) {
            $message = sprintf($message, $placeholder);
        }

        $this->message = $message;    
    }
}
