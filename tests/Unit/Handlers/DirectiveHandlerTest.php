<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Traits\DirectiveHandling;

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
