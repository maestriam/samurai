<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\FileSystem\Support\FileSystem;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeThemeTest extends ThemeTestCase
{
    public function testCreateTheme()
    {
        $theme = new Theme('bands/ozzy');

        $theme->make();
    }    
}