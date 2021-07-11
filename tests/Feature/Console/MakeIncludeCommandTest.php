<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Illuminate\Support\Facades\Artisan;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Tests\TestCase;

class MakeIncludeCommandTest extends TestCase
{    
    public function testMakeValidInclude()
    {
        $theme = 'bands/slayer';
        $name  = 'songs/world-painted-blood';
        $path  = $this->simulatePath($name);

        $this->theme($theme)->findOrCreate()->use();

        $info = sprintf('Include [%s] created into [%s]: %s', $name, $theme, $path); 

        $cmd = sprintf("samurai:make-include %s %s", $name, $theme);

        $this->artisan($cmd)->expectsOutput($info)->assertExitCode(0);
    }

    public function testMakeIncludeWithReverseOrder()
    {
        $theme = 'bands/slayer';
        $name  = 'mandatory-suicide';

        $this->theme($theme)->findOrCreate()->use();

        $cmd = sprintf("samurai:make-include %s %s", $theme, $name);

        $this->artisan($cmd)->assertExitCode(InvalidThemeNameException::CODE);
    }

    public function testMakeExistingInclude()
    {
        $theme = 'bands/slayer';
        $name  = 'bloodline';
        $code  = DirectiveExistsException::CODE;
        $error = 'Error to create include: The [%s] directive already exists in [%s] theme.';

        $this->theme($theme)->findOrCreate()->use();

        $cmd = sprintf("samurai:make-include %s %s", $name, $theme);
        $msg = sprintf($error, $name, $theme);

        $this->artisan($cmd)->assertExitCode(0);
        $this->artisan($cmd)->expectsOutput($msg)->assertExitCode($code);
    }

    private function simulatePath(string $sentence) : string
    {
        $base = config('samurai.structure.include');

        $path = sprintf('/%s%s-include.blade.php', $base, $sentence); 

        return FileSystem::folder($path)->sanitize();
    }
}