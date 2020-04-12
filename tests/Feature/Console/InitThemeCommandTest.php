<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;

class InitThemeCommandTest extends TestCase
{
    use Themeable, WithFaker, FakeValues;
    
    /**
     * Verifica se consegue percorrer em todas as perguntas
     * do questionário com sucesso
     *
     * @return void
     */
    public function testInitTheme()
    {
        $theme  = $this->fakeTheme();
        $author = $this->fakeAuthor();    
        $desc   = $this->fakeDescription();    

        $this->initTheme($theme, $author, $desc);
    }

    /**
     * Verifica se consegue continuar com o questionário
     * passando um nome de tema inválido, como parâmetro
     *
     * @return void
     */
    public function testInvalidTheme()
    {
        $theme = 'vendor invalid';
        $quest = $this->wizard()->theme();

        $this->artisan('samurai:init')
             ->expectsQuestion($quest->ask, $theme)
             ->assertExitCode(INVALID_THEME_NAME_CODE);
    }

    /**
     * Verifica se consegue continuar com o questionário
     * passando um nome de tema inválido, como parâmetro
     *
     * @return void
     */
    public function testInvalidAuthor()
    {
        $wizTheme  = $this->wizard()->theme();
        $wizAuthor = $this->wizard()->author();

        $theme  = $this->fakeTheme();
        $author = 'wrong author';

        $this->artisan('samurai:init')
             ->expectsQuestion($wizTheme->ask, $theme)
             ->expectsQuestion($wizAuthor->ask, $author)
             ->assertExitCode(INVALID_AUTHOR_CODE);
    }

    /**
     * Verifica se consegue percorrer em todo o questionário
     *
     * @param string $theme
     * @param string $author
     * @param string $desc
     * @return void
     */
    private function initTheme($theme, $author, $desc)
    {
        $wizTheme  = $this->wizard()->theme();
        $wizAuthor = $this->wizard()->author();
        $wizDesc   = $this->wizard()->description();

        $confirm = $this->wizard()->confirm($theme, $author, $desc);

        $this->artisan('samurai:init')
             ->expectsQuestion($wizTheme->ask, $theme)
             ->expectsQuestion($wizAuthor->ask, $author)
             ->expectsQuestion($wizDesc->ask, $desc)
             ->expectsConfirmation($confirm->ask, true)
             ->assertExitCode(0);
    }
}
