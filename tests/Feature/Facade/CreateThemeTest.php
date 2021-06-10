<?php

namespace Maestriam\Samurai\Tests\Feature\Facade;

use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\TestCase;

class CreateThemeTest extends TestCase
{
    public function testCreateTheme()
    {
        $name = 'bands/winger';

        $theme = Samurai::theme($name)->make();

        $this->assertValidTheme($theme);
    }
}