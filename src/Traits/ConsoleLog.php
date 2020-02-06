<?php

namespace Maestriam\Samurai\Traits;

use Illuminate\Support\Facades\Lang;

/**
 * Funções compartilhadas para manipulação de temas
 */
trait ConsoleLog
{
    /**
     * Exibe uma mensagem de erro para o console e envia o código
     * de erro para Debug
     *
     * @param string $key
     * @param integer $code
     * @return integer
     */
    public final function failed(string $message, int $code, bool $verbose = false)
    {
        if ($verbose) {
            $message = Lang::get('Samurai::console.' .$message);
        }

        $this->error($message);

        return $code;
    }

    /**
     * Exibe uma mensagem de sucesso e retorna o código
     *
     * @param string $key
     * @return integer
     */
    public final function success(string $message, int $code = 0, bool $verbose = false) : string
    {
        if (! $verbose) {
            $message = Lang::get('Samurai::console.' .$message);
        }

        $this->info($message);

        return $code;
    }
}
