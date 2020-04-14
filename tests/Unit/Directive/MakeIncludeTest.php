<?php

namespace Maestriam\Samurai\Tests\Unit\Directive;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;
use Maestriam\Samurai\Traits\Testing\ContestDirective;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeIncludeTest extends TestCase
{
    use WithFaker, Themeable, FakeValues, ContestDirective;

    public function testHappyPath()
    {
        $theme   = $this->fakeTheme();
        $include = $this->fakeInclude();

        $this->success($theme, $include);
    }
}