<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Exceptions\ThemeExistsException;
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
    
    public function testeCreatingExistingTheme()
    {
        $name = 'bands/helloween';

        $err = 'Error to create theme: The theme [%s] already exists in project.';
        $cmd = sprintf('samurai:make-theme %s', $name);
        $out = sprintf($err, $name);
        
        $this->artisan($cmd)->assertExitCode(0);

        $this->artisan($cmd)
             ->expectsOutput($out)
             ->assertExitCode(ThemeExistsException::CODE);
    }
}