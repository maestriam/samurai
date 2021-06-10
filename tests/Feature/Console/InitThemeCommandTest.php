<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\TestCase;

class InitThemeCommandTest extends TestCase
{       
     /**
     * Verifica se consegue percorrer por todas as pessoas
     *
     * @param string $theme
     * @param string $author
     * @param string $desc
     * @return void
     */
    public function testWizardPassesAllQuests()
    {
          $theme  = 'bands/jethro-tull';
          $author = 'Ian Anderson <ian@jethro tull.com>';
          $descr  = 'Aqualung, my friend';

          $this->assertSuccessfulWizard($theme, $author, $descr);
    }

    public function assertSuccessfulWizard($theme, $author, $desc)
    {
        $questTheme  = Samurai::wizard()->theme();
        $questAuthor = Samurai::wizard()->author();
        $questDescr  = Samurai::wizard()->description();

        $confirm = Samurai::wizard()->confirm($theme, $author, $desc);

        $this->artisan('samurai:init')
             ->expectsQuestion($questTheme->ask, $theme)
             ->expectsQuestion($questAuthor->ask, $author)
             ->expectsQuestion($questDescr->ask, $desc)
             ->expectsConfirmation($confirm->ask, true)
             ->assertExitCode(0);
    }
}