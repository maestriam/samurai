<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Tests\TestCase;

class MakeIncludeCommandTest extends TestCase
{    
    public function testMakeValidInclude()
    {
        $theme = 'bands/slayer';
        $name = 'world-painted-blood';

        $this->theme($theme)->findOrCreate()->use();

        $cmd = sprintf("samurai:make-include %s %s", $name, $theme);

        $this->artisan($cmd)->assertExitCode(0);
    }

    public function testMakeIncludeWithReverseOrder()
    {
        $theme = 'bands/slayer';
        $name = 'mandatory-suicide';

        $this->theme($theme)->findOrCreate()->use();

        $cmd = sprintf("samurai:make-include %s %s", $theme, $name);

        $this->artisan($cmd)->assertExitCode(InvalidThemeNameException::CODE);
    }
}