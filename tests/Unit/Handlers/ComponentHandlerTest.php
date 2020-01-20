<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;

class ComponentHanlderTest extends TestCase
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
    }
}
