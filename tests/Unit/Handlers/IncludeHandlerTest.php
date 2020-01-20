<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;

class IncludeHanlderTest extends TestCase
{
    use ThemeHandling, DirectiveHandling, WithFaker;

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
    }
}
