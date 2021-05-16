<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeThemeTest extends ThemeTestCase
{
    public function testCreateTheme()
    {
        $name = 'xuxu/pacoca';

        $theme = new Theme($name);

        $ret =  $theme->build();
    }    
}