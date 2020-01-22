<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;

class MakeIncludeCommandTest extends TestCase
{
    use WithFaker, ThemeHandling, DirectiveHandling;

    /**
     * Verifica se o comando Artisan para criação de includes
     * está funcionando com sucesso
     *
     * @return void
     */
    public function testMakeInclude()
    {
        $theme   = $this->faker->word();
        $include = $this->faker->word();
        $params  = ['theme' => $theme, 'name' => $include];

        $this->theme()->create($theme);

        $code = Artisan::call('samurai:make-include', $params);

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
        $include = $this->faker->word();
        $theme   = $this->faker->word() . time();
        $params  = ['theme' => $theme, 'name' => $include];

        $code = Artisan::call('samurai:make-include', $params);

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
        $include = $this->faker->word();

        $this->theme()->create($theme);
        $this->directive()->include($theme, $include);

        $params = ['theme' => $theme, 'name' => $include];

        $code = Artisan::call('samurai:make-include', $params);

        $this->assertIsInt($code);
        $this->assertEquals(2, $code);
    }

    /**
     * Verifica se é possível criar um include com um nome inválido
     *
     * @return void
     */
    public function testInvalidName()
    {
        $theme   = $this->faker->word();
        $include = time() . $this->faker->word();
        $params  = ['theme' => $theme, 'name' => $include];

        $this->theme()->create($theme);

        $code = Artisan::call('samurai:make-include', $params);

        $this->assertIsInt($code);
        $this->assertEquals(3, $code);
    }

}
