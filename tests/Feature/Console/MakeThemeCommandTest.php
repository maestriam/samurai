<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Tests\TestCase;

class MakeThemeCommandTest extends TestCase
{    
    public function testMakeValidTheme()
    {
        $theme = 'bands/helloween';

        $cmd = sprintf("samurai:make-theme %s", $theme);

        $this->artisan($cmd)->assertExitCode(0);
    }

    public function testInvalidTheme()
    {
        $theme = 'boy-bands';

        $cmd = sprintf("samurai:make-theme %s", $theme);

        $this->artisan($cmd)->assertExitCode(InvalidThemeNameException::CODE);
    }
}