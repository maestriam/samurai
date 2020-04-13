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

        $this->success($theme, $author, $desc);
    }

    /**
     * Verifica se consegue continuar com o questionário
     * passando um nome de tema inválido, como parâmetro
     *
     * @return void
     */
    public function testInvalidThemeName()
    {
        $themes = [
            'vendor',
            '/invalid',
            'vëndor/madchen',
            'vendor/mädchen',
            'vendor name/theme-name',
            'vendor-name/theme name',
        ];

        foreach ($themes as $case) {
            $this->failedTheme($case);
        }
    }

    /**
     * Verifica se consegue continuar com o questionário
     * passando um nome de tema inválido, como parâmetro
     *
     * @return void
     */
    public function testInvalidAuthor()
    {
        $theme  = $this->fakeTheme();

        $authors = [
            'Wrong author',  
            'wrong author<mail@mail.com>',
            'wrong author mail@mail.com',
            'wrong author <m!ail@mail.com>',
            'wrong authör <mail@mail.com>',
            'mail@mail.com',
        ];
        
        foreach ($authors as $case) {
            $this->failedAuthor($theme, $case);
        }
    }

    /**
     * Verifica se consegue percorrer em todo o questionário
     *
     * @param string $theme
     * @param string $author
     * @param string $desc
     * @return void
     */
    private function success($theme, $author, $desc)
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

    /**
     * Verifica se há erro na pergunta do nome do tema
     *
     * @param string $theme
     * @return void
     */
    private function failedTheme($theme)
    {
        $quest = $this->wizard()->theme();

        $this->artisan('samurai:init')
             ->expectsQuestion($quest->ask, $theme)
             ->assertExitCode(INVALID_THEME_NAME_CODE);
    }

    /**
     * Verifica se há erro na pergunta do autor
     *
     * @param string $theme
     * @param string $author
     * @return void
     */
    public function failedAuthor($theme, $author)
    {
        $wizTheme  = $this->wizard()->theme();
        $wizAuthor = $this->wizard()->author();

        $this->artisan('samurai:init')
             ->expectsQuestion($wizTheme->ask, $theme)
             ->expectsQuestion($wizAuthor->ask, $author)
             ->assertExitCode(INVALID_AUTHOR_CODE);
    }
}
