<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\ThemeTesting;
use Illuminate\Foundation\Testing\WithFaker;

class MakeThemeCommandTest extends TestCase
{
    use Themeable, ThemeTesting, WithFaker;

    /**
     * Verifica se o comando para publicação de temas está OK
     *
     * @return void
     */
    public function testCreateTheme()
    {
        $theme = $this->themeName();

        $this->executeCommand($theme, 0);
    }

    /**
     * Executa o comando para criação de tema via console
     *
     * @param $name
     * @param $expected
     * @return void
     */
    private function executeCommand($name, $expected)
    {
        $command = sprintf('samurai:make-theme %s', $name);

        $code = Artisan::call($command);

        $this->assertIsInt($code);
        $this->assertEquals($expected, $code);
    }

    // /**
    //  * Verifica se o comando de publicar consegue validar
    //  * temas inexistentes
    //  *
    //  * @return void
    //  */
    // public function testExistsTheme()
    // {
    //     $name  = $this->faker->word() .time();

    //     $this->theme()->findOrCreate($name);

    //     $code = Artisan::call("samurai:make-theme {$name}");

    //     $this->assertIsInt($code);
    //     $this->assertEquals(104, $code);
    // }

    // /**
    //  * Verifica se o comando de publicar consegue validar
    //  * temas inexistentes
    //  *
    //  * @return void
    //  */
    // public function testInvalidTheme()
    // {
    //     $theme = time() . $this->faker->word() . time();

    //     $code  = Artisan::call("samurai:make-theme {$theme}");

    //     $this->assertIsInt($code);
    //     $this->assertEquals(101, $code);
    // }
}
