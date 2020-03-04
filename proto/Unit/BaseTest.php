<?php

namespace Maestriam\Samurai\Tests;

use Tests\TestCase;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Models\Directive;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class BaseTest extends TestCase
{
    use Themeable, WithFaker;

    public function testAllThemes()
    {
        $name = $this->faker->word();
        $this->theme($name)->findOrBuild();

        $themes = $this->base()->all();
        $this->assertIsArray($themes);

        foreach ($themes as $theme) {
            $this->assertInstanceOf(Theme::class, $theme);
        }
    }
}
