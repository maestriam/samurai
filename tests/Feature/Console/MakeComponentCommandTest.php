<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;

class MakeComponentCommandTest extends TestCase
{
    use Themeable, WithFaker, FakeValues;
    
    public function testHappyPath()
    {
        $theme     = $this->base()->current();
        $component = $this->fakecomponent();

        $this->success($theme->vendor, $component);
    }

    public function testInvalid()
    {
        $theme     = 'vendor';
        $component = 'comp';

        $this->failure($theme, $component);
    }

    private function success($theme, $component)
    {
        $cmd = sprintf("samurai:make-component %s %s", $theme, $component);
        
        $this->artisan($cmd)->assertExitCode(0);
    }
    
    private function failure($theme, $component)
    {
        $cmd = sprintf("samurai:make-component %s %s", $theme, $component);
        
        $this->artisan($cmd)->assertExitCode(INVALID_THEME_NAME_CODE);
    }
}