<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

class ComponenteHanlderTest extends TestCase
{
    use ThemeHandling, DirectiveHandling, WithFaker;

    /**
     * Executa a criação de um component com sucesso
     *
     * @return void2
     */
    public function testCreateComponent()
    {
        $theme     = $this->faker->word();
        $component = $this->faker->word();

        $this->theme()->findOrCreate($theme);

        $object = $this->directive()->component($theme, $component);

        $this->assertInstanceOf(Directive::class, $object);
        $this->assertInstanceOf(Theme::class, $object->theme);
    
        $this->assertFileExists($object->path);
        $this->assertFileIsReadable($object->path);
    }
    
    /**
     * Verifica se todas as propriedades principais do objeto
     * Directive estão corretas e com a tipagem certa
     * 
     * @return void
     */
    public function testAnalyzeObject()
    {
        $theme   = $this->faker->word();
        $component = $this->faker->word();        

        $attrs   = ['name', 'type', 'theme', 'path'];
    
        $this->theme()->findOrCreate($theme);
        
        $object = $this->directive()->component($theme, $component);

        foreach ($attrs as $attr) {
            $this->assertObjectHasAttribute($attr, $object);
            $this->assertIsString($object->name);
        }
    }

    /**
     * Verifica se é possível criar um component com um nome inválido
     * com nome começando com números
     * 
     * @return void
     */
    public function testInvalidNameWithNumbers()
    {
        return $this->invalidNameTest('123component');
    }
    
    /**
     * Verifica se é possível criar um component com um nome inválido
     * com caracteres especiais
     * 
     * @return void
     */
    public function testInvalidNameWithSpecialChars()
    {
        return $this->invalidNameTest('inc$ud#');
    }
    
    /**
     * Verifica se é possível criar um component com um nome inválido
     * com traços
     * 
     * @return void
     */
    public function testInvalidNameWithDash()
    {
        return $this->invalidNameTest('my-component');
    }

    /**
     * Verifica se é possível criar um component com um tema 
     * inexistente
     * 
     * @return void
     */
    public function testWithInvalidTheme()
    {
        $this->expectException(ThemeNotFoundException::class);
        
        $theme   = $this->faker->word() . '-' . time();
        $component = $this->faker->word();
        
        $this->directive()->component($theme, $component);        
    }
    
    /**
     * Verifica se é possível criar dois components com o mesmo
     * nome
     * 
     * @return void
     */
    public function testExistsTheme()
    {
        $this->expectException(DirectiveExistsException::class);

        $theme = $this->faker->word();
        $name  = $this->faker->word();

        $this->theme()->findOrCreate($theme);

        $this->directive()->component($theme, $name);
        $this->directive()->component($theme, $name);
    }

    /**
     * 
     * @param string $name
     * @return void
     */
    private function invalidNameTest(string $name)
    {
        $this->expectException(InvalidDirectiveNameException::class);
        
        $theme = $this->faker->word();

        $this->theme()->findOrCreate($theme);

        $this->directive()->component($theme, $name);
    }
}
