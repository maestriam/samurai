<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;

class MakeThemeCommandTest extends TestCase
{
    use Themeable, WithFaker, FakeValues;
    
    public function testHappyPath()
    {
        $theme = $this->fakeTheme();

        $this->success($theme);
    }
    
    private function success($theme)
    {
        $cmd = sprintf("samurai:make-theme %s", $theme);
        
        $this->artisan($cmd)->assertExitCode(0);
    }
    
}