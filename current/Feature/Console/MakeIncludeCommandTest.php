<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeTesting;
use Illuminate\Foundation\Testing\WithFaker;

class MakeIncludeCommandTest extends TestCase
{
    use WithFaker, ThemeTesting, Themeable;

    /**
     * Verifica se o comando Artisan para criação de includes
     * está funcionando com sucesso
     *
     * @return void
     */
    public function testMakeInclude()
    {
        $theme   = $this->themeName();
        $include = $this->includeName();

        return $this->executeCommand($theme, $include, 0);
    }

    /**
     * Função auxiliar para criação de componente via comando
     *
     * @param $theme
     * @param $direct
     * @param $expected
     * @return void
     */
    private function executeCommand($theme, $direct, $expected)
    {
        $this->theme($theme)->findOrBuild();

        $command = sprintf('samurai:make-include %s %s', $theme, $direct);

        $code = Artisan::call($command);

        $this->assertIsInt($code);
        $this->assertEquals($expected, $code);
    }

    /**
     * Verifica se dá erro ao chamar o comando passando
     * um tema que não existe
     *
     * @return void
     */
    // public function testInvalidTheme()
    // {
    //     $include = $this->faker->word();
    //     $theme   = $this->faker->word() . time();

    //     $params = [
    //         'theme' => $theme,
    //         'name'  => $include
    //     ];

    //     $code = Artisan::call('samurai:make-include', $params);

    //     $this->assertIsInt($code);
    //     $this->assertEquals(103, $code);
    // }

    // /**
    //  * Verifica se dá erro ao chamar o comando passando
    //  * um tema que não existe
    //  *
    //  * @return void
    //  */
    // public function testIncludeExists()
    // {
    //     $theme   = $this->faker->word();
    //     $include = $this->faker->word();

    //     $this->theme()->findOrCreate($theme);

    //     $this->directive()->include($theme, $include);

    //     $params = [
    //         'theme' => $theme,
    //         'name'  => $include
    //     ];

    //     $code = Artisan::call('samurai:make-include', $params);

    //     $this->assertIsInt($code);
    //     $this->assertEquals(203, $code);
    // }

    // /**
    //  * Verifica se é possível criar um include com um nome inválido
    //  * começando com número
    //  *
    //  * @return void
    //  */
    // public function testInvalidNameWithNumbers()
    // {
    //     $this->invalidNameTest('123include');
    // }

    //  /**
    //  * Verifica se é possível criar um include com um nome inválido
    //  * separando nomes por traços
    //  *
    //  * @return void
    //  */
    // public function testInvalidNameWithSpecialChars()
    // {
    //     return $this->invalidNameTest('m*inc!ud&');
    // }

    // /**
    // * Verifica se é possível criar um include com um nome inválido
    // * separando nomes por traços
    // *
    // * @return void
    // */
    // public function testInvalidNameWithDash()
    // {
    //     return $this->invalidNameTest('my-include');
    // }

    // /**
    //  * Função auxiliar para verificação de testes com nomes inválidos
    //  */
    // private function invalidNameTest(string $include)
    // {
    //     $theme = $this->faker->word();

    //     $params = [
    //         'theme' => $theme,
    //         'name'  => $include
    //     ];

    //     $this->theme()->findOrCreate($theme);

    //     $code = Artisan::call('samurai:make-include', $params);

    //     $this->assertIsInt($code);
    //     $this->assertEquals(201, $code);
    // }
}
