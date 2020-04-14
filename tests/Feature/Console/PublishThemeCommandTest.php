<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;

class PublishThemeCommandTest extends TestCase
{
    use Themeable, WithFaker, FakeValues;
    
    public function testHappyPath()
    {
        $theme = $this->base()->current();

        $this->success($theme->vendor);
    }
    
    private function success($theme)
    {
        $cmd = sprintf("samurai:publish %s", $theme);
        
        $this->artisan($cmd)->assertExitCode(0);
    }
    
}