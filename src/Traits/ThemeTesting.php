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
        $errors[INVALID_THEME_NAME_CODE]     = InvalidThemeNameException::class;
        $errors[INVALID_DIRECTIVE_NAME_CODE] = InvalidDirectiveNameException::class;

        return $errors[$index];
    }    

    /**
     * Undocumented function
     *
     * @return string
     */
    private final function themeName() : string
    {
        $vendor = $this->generateVendor();
        $theme  = $this->generateTheme();

        return $vendor . '/' . $theme;
    }

    /**
     * Retorna um nome aleatório para criação de um tema
     *
     * @return string
     */
    private final function generateTheme() : string
    {
        return 'theme-' . Str::random(50);
    }
    
    /**
     * Undocumented function
     *
     * @return string
     */
    private final function generateVendor() : string
    {
        return 'vendor-' . Str::random(50);
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