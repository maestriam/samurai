<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class SyntaxValidator
{
    /**
     *
     *
     * @param string $name
     * @return boolean
     */
    public function theme(string $name) : bool
    {
        $startNumbers   = "/^[\d]/";
        $onlyValidChars = "/^[\w&.\-]+$/";

        if (preg_match($startNumbers, $name)) {
            return false;
        }

        if (! preg_match($onlyValidChars, $name)) {
            return false;
        }

        return true;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return boolean
     */
    public function directive(string $name) : bool
    {
        $startNumbers   = "/^[\d]/";
        $onlyValidChars = "/^[a-zA-Z0-9\/\-]+$/";

        if (preg_match($startNumbers, $name)) {
            return false;
        }

        if (! preg_match($onlyValidChars, $name)) {
            return false;
        }

        return true;
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @return boolean
     */
    public function type(string $type) : bool
    {
        $types = Config::get('Samurai.species');

        return (in_array($type, $types)) ? true : false;
    }
}
