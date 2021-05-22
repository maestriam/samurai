<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ThemeTestCase extends TestCase
{
    public function testThemeDescription()
    {
        $theme = new Theme('bands/iron-maiden');

        $desc = 'Run to the hills';

        $theme->description($desc);

        $this->assertIsString($theme->description());
        $this->assertEquals($desc, $theme->description());
    }
    
}