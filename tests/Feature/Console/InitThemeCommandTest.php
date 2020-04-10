<?php

namespace Maestriam\Samurai\Tests\Foundation\SyntaxValidator;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Foundation\SyntaxValidator;

class InitThemeCommandTest extends TestCase
{
    use Themeable;

    public function testInitTheme()
    {
        $theme  = 'vendor/xxxxxxx';
        $author = 'Giu Foo <mail@gmail.com>';    
        $desc   = 'My description';    

        $this->initTheme($theme, $author, $desc);
    }

    private function initTheme($inTheme, $inAuthor, $inDesc)
    {
        $theme  = $this->wizard()->theme();
        $author = $this->wizard()->author();
        $desc   = $this->wizard()->description();

        $confirm = $this->wizard()->confirm($inTheme, $inAuthor, $inDesc);

        $this->artisan('samurai:init')
             ->expectsQuestion($theme->ask, $inTheme)
             ->expectsQuestion($author->ask, $inAuthor)
             ->expectsQuestion($desc->ask, $inDesc)
             ->expectsConfirmation($confirm->ask, true)
             ->assertExitCode(0);
    }
}
