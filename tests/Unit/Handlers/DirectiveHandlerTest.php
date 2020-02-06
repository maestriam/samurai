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
