<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;

class PublishThemeCommandTest extends TestCase
{
    use ThemeHandling, DirectiveHandling, WithFaker;

    /**
     * Verifica se o comando para publicação de temas está OK
     *
     * @return void
     */
    public function testPublishTheme()
    {
        $theme = $this->faker->word();
        
        $this->theme()->findOrCreate($theme);

        $code = Artisan::call("samurai:publish {$theme}");

        $this->assertIsInt($code);
        $this->assertEquals(0, $code);
    }

    /**
     * Verifica se o comando de publicar consegue validar
     * temas inexistentes
     *
     * @return void
     */
    public function testInvalidTheme()
    {
        $theme = $this->faker->word() . '-invalid-theme' . time();
        $code  = Artisan::call("samurai:publish {$theme}");

        $this->assertIsInt($code);
        $this->assertEquals(103, $code);
    }
}
