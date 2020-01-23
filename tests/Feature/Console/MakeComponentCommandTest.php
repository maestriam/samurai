<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;

class MakeComponentCommandTest extends TestCase
{
    use WithFaker, ThemeHandling, DirectiveHandling;

    /**
     * Verifica se o comando Artisan para criação de components
     * está funcionando com sucesso
     *
     * @return void
     */
    public function testMakeComponent()
    {
        $theme     = $this->faker->word();
        $component = $this->faker->word();
        $params    = ['theme' => $theme, 'name' => $component];

        $this->theme()->create($theme);

        $code = Artisan::call('samurai:make-component', $params);

        $this->assertIsInt($code);
        $this->assertEquals(0, $code);
    }

    /**
     * Verifica se dá erro ao chamar o comando passando
     * um tema que não existe
     *
     * @return void
     */
    public function testInvalidTheme()
    {
        $component = $this->faker->word();
        $theme     = $this->faker->word() . time();
        $params    = ['theme' => $theme, 'name' => $component];

        $code = Artisan::call('samurai:make-component', $params);

        $this->assertIsInt($code);
        $this->assertEquals(1, $code);
    }

    /**
     * Verifica se dá erro ao chamar o comando passando
     * um tema que não existe
     *
     * @return void
     */
    public function testComponetExists()
    {
        $theme   = $this->faker->word();
        $component = $this->faker->word();

        $this->theme()->create($theme);
        $this->directive()->component($theme, $component);

        $params = ['theme' => $theme, 'name' => $component];

        $code = Artisan::call('samurai:make-component', $params);

        $this->assertIsInt($code);
        $this->assertEquals(2, $code);
    }

    /**
     * Verifica se é possível criar um component com um nome inválido
     *
     * @return void
     */
    public function testInvalidName()
    {
        $theme   = $this->faker->word();
        $component = time() . $this->faker->word();
        $params  = ['theme' => $theme, 'name' => $component];

        $this->theme()->create($theme);

        $code = Artisan::call('samurai:make-component', $params);

        $this->assertIsInt($code);
        $this->assertEquals(3, $code);
    }

}
