<?php

namespace Maestriam\Samurai\Exceptions;

use Config;
use Exception;
use Maestriam\Samurai\Traits\Shared\ConfigAccessors;

class BaseException extends Exception
{
    use ConfigAccessors;

    /**
     * Inicia os atributos de acordo com o código de erro
     *
     * @param string $code
     * @return void
     */
    public function initialize(string $code, string ...$placeholders)
    {
        $this->setCode($code);
        $this->setMessage($code, $placeholders);
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
    protected function setMessage(string $code, array $placeholders = [])
    {
        $err     = $this->getErrorConfig($code);
        $message = $err['msg'];

        $message = vsprintf($message, $placeholders);

        $this->message = $message;    
    }
}
