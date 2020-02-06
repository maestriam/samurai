<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

class ComponentHandlerTest extends TestCase
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
}