<?php

namespace Maestriam\Katana\Traits;

use Lang;

trait MessageLogging
{
    /**
     * Retorna uma mensagem de
     *
     * @param string $key
     * @return string
     */
    public function logging(string $key) : string
    {
        $key = 'katana::' . $key;

        return Lang::get($key);
    }
}
