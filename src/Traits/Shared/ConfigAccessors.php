<?php

namespace Maestriam\Samurai\Traits\Shared;

use Config;

trait ConfigAccessors
{
    /**
     * Undocumented function
     *
     * @param integer $code
     * @return array
     */
    private function getErrorConfig(string $code = null) : array
    {
        $errors = Config::get('Samurai.errors'); 

        if ($code) {
            return $errors[$code];
        }

        return $errors;
    }
}