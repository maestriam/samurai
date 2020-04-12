<?php

namespace Maestriam\Samurai\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;

class InvalidTypeDirectiveException extends Exception
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->setMessage($type);
        $this->setCode(INVALID_TYPE_DIRECTIVE_CODE);
    }

    /**
     * Define a mensagem de texto que será enviado para o cliente
     *
     * @param string $type
     * @return void
     */
    public function setMessage(string $type)
    {
        $key = 'Samurai::exceptions.theme.invalid-type';

        $this->message = Lang::get($key, ['name' => $type]);
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
