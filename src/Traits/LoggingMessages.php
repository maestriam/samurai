<?php

namespace Maestriam\Samurai\Traits;

use Illuminate\Support\Facades\Lang;

/**
 * Funções compartilhadas para manipulação de temas
 */
trait LoggingMessages
{
    /**
     * Exibe uma mensagem de erro e retorna o código para debug
     *
     * @param string $key
     * @param integer $code
     * @return integer
     */
    public final function _error(string $key, int $code) : int
    {
        $message = Lang::get('Samurai::console.' .$key);

        $this->error($message);

        return $code;
    }

    /**
     * Exibe uma mensagem de sucesso e retorna o código
     *
     * @param string $key
     * @return integer
     */
    public final function _success(string $key) : int
    {
        $message = Lang::get('Samurai::console.' .$key);

        $this->info($message);

        return 0;
    }
}
