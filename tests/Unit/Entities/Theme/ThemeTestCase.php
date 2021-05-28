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
        $descr = 'Run to the hills';

        $theme->description($descr);

        $this->assertIsString($theme->description());
        $this->assertEquals($descr, $theme->description());
    }    
}