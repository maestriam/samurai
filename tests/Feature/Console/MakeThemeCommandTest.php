<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;

class MakeThemeCommandTest extends TestCase
{
    use ThemeHandling, DirectiveHandling, WithFaker;

    /**
     * Verifica se o comando para publicação de temas está OK
     *
     * @return void
     */
    public function testCreateTheme()
    {
        $theme = $this->faker->word() . time();

        $code = Artisan::call("samurai:make-theme {$theme}");

        $this->assertIsInt($code);
        $this->assertEquals(0, $code);
    }

    /**
     * Verifica se o comando de publicar consegue validar
     * temas inexistentes
     *
     * @return void
     */
    public function testExistsTheme()
    {
        $theme = $this->faker->word() . time();

        $obj = $this->theme()->create($theme);

        $code  = Artisan::call("samurai:make-theme {$theme}");

        $this->assertIsInt($code);
        $this->assertEquals(102, $code);
    }

    /**
     * Verifica se o comando de publicar consegue validar
     * temas inexistentes
     *
     * @return void
     */
    public function testInvalidTheme()
    {
        $theme = time() . $this->faker->word() . time();

        $code  = Artisan::call("samurai:make-theme {$theme}");

        $this->assertIsInt($code);
        $this->assertEquals(101, $code);
    }
}
