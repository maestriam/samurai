<?php

namespace Maestriam\Samurai\Exceptions;

use Exception;

abstract class BaseException extends Exception
{
    /**
     * Inicia os atributos de acordo com o código de erro
     *
     * @param string $code
     * @return void
     */
    public function initialize(string ...$params)
    {
        $this->setCode()->setMessage($params);
    }

    /**
     * Define qual será o número do código de retorno
     *
     * @param integer $code
     * @return BaseException
     */
    protected function setCode() : BaseException
    {
        $this->code = $this->getErrorCode();

        return $this;
    }

    /**
     * Define a mensagem de texto que será enviado para o cliente
     *
     * @param string $theme
     * @param string $name
     * @return BaseException
     */
    protected function setMessage(array $params = []) : BaseException
    {
        $message = $this->getErrorMessage();

        $this->message = vsprintf($message, $params);

        return $this;
    }

    /**
     * Retorna a código de erro que será enviada ao cliente.  
     *
     * @return string
     */
    abstract public function getErrorCode() : string;

    
    /**
     * Retorna a mensagem de erro que será enviada ao cliente.  
     *
     * @return string
     */
    abstract public function getErrorMessage() : string;
}
