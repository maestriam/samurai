<?php

namespace Maestriam\Samurai\Tests\Unit\Theme;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;
use Maestriam\Samurai\Traits\Testing\ContestTheme;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class FindOrCreateThemeTest extends TestCase
{
    use WithFaker, Themeable, FakeValues, ContestTheme;

    public function testHappyPath()
    {
        $name  = $this->fakeTheme();
        $theme = $this->theme($name)
                      ->findOrBuild();

        $this->contestTheme($theme);
    }
}