<?php

namespace Maestriam\Samurai\Tests\Feature\Facade;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\TestCase;

class GetCurrentThemeTest extends TestCase
{
    public function testGetExistingTheme()
    {
        $theme = new Theme('bands/alice-in-chains');

        $theme->make()->use();

        $current = Samurai::base()->current();

        $this->assertValidTheme($current);
    }

    public function testGetInexistingCurrentTheme()
    {
        $current = Samurai::base()->current();

        $this->assertNull($current);
    }
}