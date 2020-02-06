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

        $params = [
            'theme' => $theme, 
            'name'  => $include
        ];

        $code = Artisan::call('samurai:make-include', $params);

        $this->assertIsInt($code);
        $this->assertEquals(103, $code);
    }

    /**
     * Verifica se dá erro ao chamar o comando passando
     * um tema que não existe
     *
     * @return void
     */
    public function testIncludeExists()
    {
        $theme   = $this->faker->word();
        $include = $this->faker->word();
        
        $this->theme()->create($theme);

        $this->directive()->include($theme, $include);
        
        $params = [
            'theme' => $theme, 
            'name'  => $include
        ];
        
        $code = Artisan::call('samurai:make-include', $params);

        $this->assertIsInt($code);
        $this->assertEquals(203, $code);
    }

    /**
     * Verifica se é possível criar um include com um nome inválido
     * começando com número
     * 
     * @return void
     */
    public function testInvalidNameWithNumbers()
    {
        $this->invalidNameTest('123include');
    }

     /**
     * Verifica se é possível criar um include com um nome inválido
     * separando nomes por traços
     * 
     * @return void
     */
    public function testInvalidNameWithSpecialChars()
    {  
        return $this->invalidNameTest('m*inc!ud&');        
    }

    /**
    * Verifica se é possível criar um include com um nome inválido
    * separando nomes por traços
    * 
    * @return void
    */
    public function testInvalidNameWithDash()
    {
        return $this->invalidNameTest('my-include');
    }

    /**
     * Função auxiliar para verificação de testes com nomes inválidos
     */
    private function invalidNameTest(string $include)
    {
        $theme = $this->faker->word();
        
        $params = [
            'theme' => $theme, 
            'name'  => $include
        ];
        
        $this->theme()->create($theme);

        $code = Artisan::call('samurai:make-include', $params);

        $this->assertIsInt($code); 
        $this->assertEquals(201, $code);
    }
}
