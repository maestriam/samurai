<?php

namespace Maestriam\Samurai\Traits\Console;

use stdClass;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;

/**
 * Funções compartilhadas para receber os parâmetros do usuário
 */
trait GetArguments
{
    /**
     * Retorna os parâmetros enviados pelo usuário
     *
     * @return stdClass
     */
    protected function getArguments() : stdClass
    {
        $arg1 = (string) $this->argument('theme');
        $arg2 = (string) $this->argument('name');

        if (strlen($arg2)) {
            return $this->toObject($arg1, $arg2);
        }

        $theme = $this->base()->current();

        if ($theme) {
            return $this->toObject($theme->vendor, $arg1);
        }

        throw new ThemeNotFoundException('');
    }

    /**
     * Retorna um objeto com os argumentos informados pelo usuário
     *
     * @param string $theme
     * @param string $name
     * @return stdClass
     */
    protected function toObject(string $theme, string $name) : stdClass
    {
        return (object) [
            'theme' => $theme,
            'name'  => $name,
        ];
    }
}
