<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;

class UseThemeCommandTest extends TestCase
{
    use Themeable, WithFaker;

    /**
     * Verifica se o comando para publicação de temas está OK
     *
     * @return void
     */
    public function testPublishTheme()
    {
        $theme = $this->faker->word();

        $this->executeCommand($theme, 0);
    }

    /**
     * Executa o comando via console
     *
     * @param $name
     * @param $expected
     * @return void
     */
    public function executeCommand($name, $expected)
    {
        $this->theme($name)->findOrBuild();

        $command = sprintf('samurai:use %s', $name);

        $code = Artisan::call($command);

        $this->assertIsInt($code);
        $this->assertEquals($expected, $code);
    }

    /**
     * Verifica se o comando de publicar consegue validar
     * temas inexistentes
     *
     * @return void
     */
    // public function testInvalidTheme()
    // {
    //     $theme = $this->faker->word() . '-invalid-theme' . time();
    //     $code  = Artisan::call("samurai:publish {$theme}");

    //     $this->assertIsInt($code);
    //     $this->assertEquals(103, $code);
    // }
}
