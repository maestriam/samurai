<?php

namespace Maestriam\Samurai\Tests\Unit\Theme;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class UseThemeTest extends TestCase
{
    use WithFaker, FakeValues, Themeable;

    public function testhappyPath()
    {
        $name  = $this->fakeTheme();
        $theme = $this->theme($name)->build();

        $checked = $this->theme($theme->vendor)->use();

        $this->success($checked);
    }
    
    public function success($checked)
    {
        $this->assertIsBool($checked);
        $this->assertTrue($checked);
    }
}