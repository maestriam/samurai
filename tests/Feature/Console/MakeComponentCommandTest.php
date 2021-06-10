<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Tests\TestCase;

class MakeComponentCommandTest extends TestCase
{    
    public function testMakeValidComponent()
    {
        $theme = 'bands/sepultura';
        $name  = 'roots-blood-roots';

        $this->theme($theme)->findOrCreate()->use();

        $cmd = sprintf("samurai:make-component %s %s", $name, $theme);

        $this->artisan($cmd)->assertExitCode(0);
    }

    public function testMakeComponentWithReverseOrder()
    {
        $theme = 'bands/sepultura';
        $name  = 'roots-blood-roots';

        $this->theme($theme)->findOrCreate()->use();

        $cmd = sprintf("samurai:make-component %s %s", $theme, $name);

        $this->artisan($cmd)->assertExitCode(InvalidThemeNameException::CODE);
    }
}