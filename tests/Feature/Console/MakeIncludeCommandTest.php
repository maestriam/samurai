<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;

class MakeIncludeCommandTest extends TestCase
{
    use Themeable, WithFaker, FakeValues;
    
    public function testHappyPath()
    {
        $theme   = $this->base()->current();
        $include = $this->fakeInclude();

        $this->success($theme->vendor, $include);
    }
    
    private function success($theme, $include)
    {
        $cmd = sprintf("samurai:make-include %s %s", $theme, $include);
        
        $this->artisan($cmd)->assertExitCode(0);
    }
}