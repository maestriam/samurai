<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Tests\TestCase;

class MakeComponentCommandTest extends TestCase
{    
    public function testMakeValidComponent()
    {
        $theme = 'bands/sepultura';
        $name  = 'roots-blood-roots';
        $path  = $this->simulatePath($name);
        
        $this->theme($theme)->findOrCreate()->use();

        $info = sprintf('Component [%s] created into [%s]: %s', $name, $theme, $path);

        $cmd = sprintf("samurai:make-component %s %s", $name, $theme);

        $this->artisan($cmd)->expectsOutput($info)->assertExitCode(0);
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

    private function simulatePath(string $sentence) : string
    {
        $base = config('samurai.structure.component');

        $ext = 'component.blade.php';

        $path = sprintf('%s%s-%s', $base, $sentence, $ext); 

        return FileSystem::folder($path)->sanitize();
    }
}