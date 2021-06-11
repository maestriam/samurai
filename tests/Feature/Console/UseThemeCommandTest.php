<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\TestCase;

class UseThemeCommandTest extends TestCase
{    
    public function testMakeValidTheme()
    {
        $theme = $this->theme('bands/saxon')->findOrCreate();

        $cmd = sprintf("samurai:use %s", $theme->package());

        $this->artisan($cmd)->assertExitCode(0);

        $current = Samurai::base()->current();
        
        $this->assertEquals($current->package(), $theme->package());
    }
}