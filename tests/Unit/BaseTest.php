<?php

namespace Maestriam\Samurai\Tests\Unit;

use Tests\TestCase;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\ThemeTesting;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class BaseTest extends TestCase
{
    use Themeable, ThemeTesting, WithFaker;

    public function testAllThemes()
    {
        $name = $this->themeName();
        $this->theme($name)->findOrBuild();

        $themes = $this->base()->all();
        $this->assertIsArray($themes);

        foreach ($themes as $theme) {
            $this->assertInstanceOf(Theme::class, $theme);
        }
    }
}
