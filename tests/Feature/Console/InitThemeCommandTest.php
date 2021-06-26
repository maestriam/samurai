<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Exceptions\ThemeExistsException;
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

    /**
     * Verifica se consegue exibir a mensagem de erro 
     * ao tentar criar um tema já existente com o wizard
     *
     * @return void
     */
    public function testWizardWithExistingTheme()
    {
        $theme = 'bands/jethro-tull';

        Samurai::theme($theme)->make();

        $this->assertFailedWizard($theme, ThemeExistsException::ERROR);
    }

    /**
     * Verifica se o wizard passou por todos os passos corretamente
     * e conseguiu criar o tema esperado. 
     *
     * @param string $theme
     * @param string $author
     * @param string $desc
     * @return void
     */
    private function assertSuccessfulWizard(string $theme, string $author, string $desc)
    {
        $quests = $this->getQuestions();
        
        $confirm = $this->getConfirmQuestions($theme, $author, $desc);

        $output = sprintf('Theme [%s] created successful.', $theme);

        $this->artisan('samurai:init')
             ->expectsQuestion($quests->theme->ask, $theme)
             ->expectsQuestion($quests->author->ask, $author)
             ->expectsQuestion($quests->desc->ask, $desc)
             ->expectsConfirmation($confirm->ask, 'yes')
             ->expectsOutput($output)
             ->assertExitCode(0);
    }

    /**
     * Retorna as questões que serão utilizadas no Wizard.  
     *
     * @return void
     */
    private function getQuestions() : object
    {
        $theme  = Samurai::wizard()->theme();
        $author = Samurai::wizard()->author();
        $descr  = Samurai::wizard()->description();

        return (object) [
            'theme'   => $theme,
            'author'  => $author,
            'desc'    => $descr,
        ];
    }

    private function getConfirmQuestions($theme, $author, $desc)
    {
        return Samurai::wizard()->confirm($theme, $author, $desc);
    }

    private function assertFailedWizard($theme, $error)
    {
        $error = sprintf($error, $theme);

        $quests = $this->getQuestions();
        $author = $quests->author->default;
        $desc   = $quests->desc->default;

        $confirm = $this->getConfirmQuestions($theme, $author, $desc);
        $message = sprintf('Error to create theme: %s', $error);

        $this->artisan('samurai:init')
             ->expectsQuestion($quests->theme->ask, $theme)
             ->expectsQuestion($quests->author->ask, $author)
             ->expectsQuestion($quests->desc->ask, $desc)
             ->expectsConfirmation($confirm->ask, 'yes')
             ->expectsOutput($message);
    }
}