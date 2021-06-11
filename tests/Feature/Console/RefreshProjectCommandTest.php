<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Tests\TestCase;

class RefreshProjectCommandTest extends TestCase
{    
    public function testMakeValidTheme()
    {
        $cmd = 'samurai:refresh';

        $this->artisan($cmd)->assertExitCode(0);
    }
}