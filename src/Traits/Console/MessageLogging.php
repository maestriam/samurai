<?php

namespace Maestriam\Samurai\Traits\Console;

use Illuminate\Support\Facades\Lang;

/**
 * Funções compartilhadas para manipulação de temas
 */
trait MessageLogging
{
    /**
     * Exibe uma mensagem de sucesso e retorna o código
     *
     * @param string $key
     * @return integer
     */
    public final function success(string $message, bool $verbose = false, string $code = '0') : string
    {
        if (! $verbose) {
            $message = Lang::get('Samurai::console.' .$message);
        }

        $this->info($message);

        return $code;
    }

    /**
     * Exibe uma mensagem de erro para o console e envia o código
     * de erro para Debug
     *
     * @param integer $code
     * @param string $key
     * @return integer
     */
    public final function failed(string $code, string $message = null, bool $verbose = false)
    {
        $err = $this->getErrorConfig($code);

        if (! $verbose)  { 
            $message = Lang::get('Samurai::console.' .$err['bash']);
        } else { 
            $message = $message;
        }

        $this->error($message);

        return $code;
    }    
}
