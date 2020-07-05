<?php

namespace Maestriam\Samurai\Traits\Console;

use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
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
        $name  = $this->getNameArgument();
        $theme = $this->getThemeArgument();

        return $this->toObject($theme, $name);
    }
    
    /**
     * Retorna o nome do nome da diretiva
     *
     * @return string
     */
    protected function getNameArgument() : string
    {
        $name = (string) $this->argument('name');

        if (! $name) {
            throw new InvalidDirectiveNameException($name);
        }

        return $name;
    }

    /**
     * Retorna o nome do tema para criação da diretiva
     *
     * @return string
     */
    protected function getThemeArgument() : string
    {   
        $console = (string) $this->argument('theme');

        if (strlen($console)) {
            return $console;
        }

        $current = $this->base()->current();

        return $current->vendor .'/'. $current->name;
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
