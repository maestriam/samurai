<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

class DirectiveHanlderTest extends TestCase
{
    use ThemeHandling, DirectiveHandling, WithFaker;

    /**
     * Executa a criação de um componente com sucesso
     *
     * @return void
     */
    public function testCreateComponent()
    {
        $theme     = $this->faker->word();
        $component = $this->faker->word();

        $this->theme()->create($theme);

        $object = $this->directive()->component($theme, $component);

        $this->assertInstanceOf(Directive::class, $object);

        $this->assertObjectHasAttribute('name', $object);
        $this->assertObjectHasAttribute('type', $object);
        $this->assertObjectHasAttribute('theme', $object);
        $this->assertObjectHasAttribute('path', $object);

        $this->assertIsString($object->name);
        $this->assertIsString($object->type);
        $this->assertIsString($object->path);

        $this->assertInstanceOf(Theme::class, $object->theme);

        $this->assertFileExists($object->path);
        $this->assertFileIsReadable($object->path);
    }

    /**
     * Executa a criação de um include com sucesso
     *
     * @return void
     */
    public function testCreateInclude()
    {
        $theme   = $this->faker->word();
        $include = $this->faker->word();

        $this->theme()->create($theme);

        $object = $this->directive()->include($theme, $include);

        $this->assertInstanceOf(Directive::class, $object);

        $this->assertObjectHasAttribute('name', $object);
        $this->assertObjectHasAttribute('type', $object);
        $this->assertObjectHasAttribute('theme', $object);
        $this->assertObjectHasAttribute('path', $object);

        $this->assertIsString($object->name);
        $this->assertIsString($object->type);
        $this->assertIsString($object->path);

        $this->assertInstanceOf(Theme::class, $object->theme);

        $this->assertFileExists($object->path);
        $this->assertFileIsReadable($object->path);
    }

    /**
     * Retorna TODOS os tipos de diretivas válidos no projeto
     *
     * @return void
     */
    public function testTypes()
    {
        $types = $this->directive()->types();

        $this->assertIsArray($types);
        $this->assertNotEmpty($types);
    }

    /**
     * Verifica se é possível criar um include com um nome inválido
     * com nome começando com números
     * 
     * @return void
     */
    public function testInvalidNameWithNumbers()
    {
        $this->expectException(InvalidDirectiveNameException::class);
        
        $name  = '123include';
        $theme = $this->faker->word();
        
        $this->theme()->create($theme);
        
        $this->directive()->include($theme, $name);
    }
    
    /**
     * Verifica se é possível criar um include com um nome inválido
     * com caracteres especiais
     * 
     * @return void
     */
    public function testInvalidNameWithSpecialChars()
    {
        $this->expectException(InvalidDirectiveNameException::class);
        
        $name  = 'inc$ud#';
        $theme = $this->faker->word();

        $this->theme()->create($theme);
        
        $this->directive()->include($theme, $name);
    }
    
    /**
     * Verifica se é possível criar um include com um nome inválido
     * com traços
     * 
     * @return void
     */
    public function testInvalidNameWithDash()
    {
        $this->expectException(InvalidDirectiveNameException::class);
        
        $name  = 'my-include';
        $theme = $this->faker->word();

        $this->theme()->create($theme);

        $this->directive()->include($theme, $name);
    }

    /**
     * Importa uma diretiva para ser usado no projeto Laravel
     *
     * @return void
     */
    public function testLoadDirective()
    {
        $theme     = $this->faker->word();
        $component = $this->faker->word();
        $include   = $this->faker->word();

        $this->theme()->create($theme);

        $this->directive()->include($theme, $include);
        $this->directive()->component($theme, $component);

        $types = $this->directive()->types();

        $directives = $this->theme()->directives($theme);

        foreach($types as $type) {
            foreach ($directives[$type] as $directive) {

                $check = $this->directive()->load($directive);

                $this->assertIsBool($check);
                $this->assertTrue($check, $directive->path);
            }
        }
    }
}
