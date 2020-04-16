<?php

namespace Maestriam\Samurai\Traits\Testing;

use Config;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

/**
 * 
 */
trait ContestDirective
{
    
    private final function success($theme, $name)
    {
        $this->theme($theme)->findOrBuild();

        $include = $this->theme($theme)
                        ->include($name)
                        ->create();
        
        $this->assertInstanceOf(Directive::class, $include);
    }

    /**
     * Retorna 
     *
     * @param [type] $code
     * @param [type] $theme
     * @param [type] $name
     * @return void
     */
    private final function failed($code, $theme, $name)
    {
        $class = $this->getErrorClass($code);

        $this->expectException($class);

        $this->theme($theme)->include($name)->create();
    }

}