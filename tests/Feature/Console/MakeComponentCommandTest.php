<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

class MakeComponentCommandTest extends TestCase
{
    use WithFaker, ThemeHandling, DirectiveHandling;

    /**
     * Verifica se o comando Artisan para criação de componentes
     * está funcionando com sucesso
     *
     * @return void
     */
    public function testMakeComponent()
    {
        $theme     = $this->faker->word();
        $component = $this->faker->word();

        $params = [
            'theme' => $theme, 
            'name'  => $component
        ];
        
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
        $theme   = $this->faker->word() . time();

        $params = [
            'theme' => $theme, 
            'name'  => $component
        ];

        $code = Artisan::call('samurai:make-component', $params);

        $this->assertIsInt($code);
        $this->assertEquals(103, $code);
    }

    /**
     * Verifica se dá erro ao chamar o comando passando
     * um tema que não existe
     *
     * @return void
     */
    public function testComponentExists()
    {
        $theme   = $this->faker->word();
        $component = $this->faker->word();
        
        $this->theme()->create($theme);

        $this->directive()->component($theme, $component);
        
        $params = [
            'theme' => $theme, 
            'name'  => $component
        ];
        
        $code = Artisan::call('samurai:make-component', $params);

        $this->assertIsInt($code);
        $this->assertEquals(203, $code);
    }

    /**
     * Verifica se é possível criar um component com um nome inválido
     * começando com número
     * 
     * @return void
     */
    public function testInvalidNameWithNumbers()
    {
        $this->invalidNameTest('123component');
    }

     /**
     * Verifica se é possível criar um component com um nome inválido
     * separando nomes por traços
     * 
     * @return void
     */
    public function testInvalidNameWithSpecialChars()
    {  
        return $this->invalidNameTest('c*mp*n&n#.');        
    }

    /**
    * Verifica se é possível criar um component com um nome inválido
    * separando nomes por traços
    * 
    * @return void
    */
    public function testInvalidNameWithDash()
    {
        return $this->invalidNameTest('my-component');
    }

    /**
     * Função auxiliar para verificação de testes com nomes inválidos
     */
    private function invalidNameTest(string $component)
    {
        $theme = $this->faker->word();
        
        $params = [
            'theme' => $theme, 
            'name'  => $component
        ];
        
        $this->theme()->create($theme);

        $code = Artisan::call('samurai:make-component', $params);

        $this->assertIsInt($code); 
        $this->assertEquals(201, $code);
    }
}
