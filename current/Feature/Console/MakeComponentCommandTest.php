<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeTesting;
use Illuminate\Foundation\Testing\WithFaker;

class MakeComponentCommandTest extends TestCase
{
    use WithFaker, ThemeTesting, Themeable;

    /**
     * Verifica se o comando Artisan para criação de componentes
     * está funcionando com sucesso
     *
     * @return void
     */
    public function testMakeComponent()
    {
        $theme     = $this->themeName();
        $component = $this->componentName();

        $this->executeCommand($theme, $component, 0);
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

        $command = sprintf('samurai:make-component %s %s', $theme, $direct);

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
    //     $component = $this->faker->word();
    //     $theme   = $this->faker->word() . time();

    //     $params = [
    //         'theme' => $theme,
    //         'name'  => $component
    //     ];

    //     $code = Artisan::call('samurai:make-component', $params);

    //     $this->assertIsInt($code);
    //     $this->assertEquals(103, $code);
    // }

    /**
     * Verifica se dá erro ao chamar o comando passando
     * um tema que não existe
     *
     * @return void
     */
    // public function testComponentExists()
    // {
    //     $theme   = $this->faker->word();
    //     $component = $this->faker->word();

    //     $this->theme()->findOrCreate($theme);

    //     $this->directive()->component($theme, $component);

    //     $params = [
    //         'theme' => $theme,
    //         'name'  => $component
    //     ];

    //     $code = Artisan::call('samurai:make-component', $params);

    //     $this->assertIsInt($code);
    //     $this->assertEquals(203, $code);
    // }

    /**
     * Verifica se é possível criar um component com um nome inválido
     * começando com número
     *
     * @return void
     */
    // public function testInvalidNameWithNumbers()
    // {
    //     $this->invalidNameTest('123component');
    // }

     /**
     * Verifica se é possível criar um component com um nome inválido
     * separando nomes por traços
     *
     * @return void
     */
    // public function testInvalidNameWithSpecialChars()
    // {
    //     return $this->invalidNameTest('c*mp*n&n#.');
    // }

    /**
    * Verifica se é possível criar um component com um nome inválido
    * separando nomes por traços
    *
    * @return void
    */
    // public function testInvalidNameWithDash()
    // {
    //     return $this->invalidNameTest('my-component');
    // }

    /**
     * Função auxiliar para verificação de testes com nomes inválidos
     */
    // private function invalidNameTest(string $component)
    // {
    //     $theme = $this->faker->word();

    //     $params = [
    //         'theme' => $theme,
    //         'name'  => $component
    //     ];

    //     $this->theme()->findOrCreate($theme);

    //     $code = Artisan::call('samurai:make-component', $params);

    //     $this->assertIsInt($code);
    //     $this->assertEquals(201, $code);
    // }
}
