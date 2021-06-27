<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Exceptions\DirectiveExistsException;
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

    public function testMakeExistingInclude()
    {
        $theme = 'bands/sepultura';
        $name  = 'roots-blood-roots';
        $error = 'Error to create component: The [%s] directive already exists in [%s] theme.';

        $this->theme($theme)->findOrCreate()->use();

        $cmd = sprintf("samurai:make-component %s %s", $name, $theme);
        $msg = sprintf($error, $name, $theme);

        $this->artisan($cmd)
             ->assertExitCode(0);

        $this->artisan($cmd)
             ->expectsOutput($msg)
             ->assertExitCode(DirectiveExistsException::CODE);

    }
}