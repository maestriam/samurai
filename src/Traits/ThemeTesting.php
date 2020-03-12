<?php

namespace Maestriam\Samurai\Traits;

use Str;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

/**
 * Funcionalidades básicas para ser usado 
 */
trait ThemeTesting
{    
    /**
     * Retorna a classe de erro de acordo com o indíce enviado
     *
     * @param integer $index
     * @return string
     */
    private final function getErrorClass(int $index) : string
    {
        $errors[INVALID_THEME_NAME]     = InvalidThemeNameException::class;
        $errors[INVALID_DIRECTIVE_NAME] = InvalidDirectiveNameException::class;

        return $errors[$index];
    }    

    /**
     * Definem as constantes que serão utilizdas durante os  testes
     *
     * @return void
     */
    private final function setConsts()
    {
        $consts = [
            'INVALID_THEME_NAME'     => 4,
            'INVALID_DIRECTIVE_NAME' => 5,
        ];

        foreach($consts as $const => $value) {

            if (defined($const)) {
                continue;
            }
            
            define($const, $value);
        }
    }

    /**
     * Retorna um nome aleatório para criação de um tema
     *
     * @return string
     */
    private final function themeName() : string
    {
        return 'theme-' . Str::random(50);
    }
    
    /**
     * Retorna um nome aleatório para criação de um componente
     *
     * @return string
     */
    private final function includeName() : string
    {
        return 'include-' . Str::random(50);
    }
    
    /**
     * Retorna um nome aleatório para criação de um componente
     *
     * @return string
     */
    private final function componentName() : string
    {
        return 'component-' . Str::random(50);
    }
}