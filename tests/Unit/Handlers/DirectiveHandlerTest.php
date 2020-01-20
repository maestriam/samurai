<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\DirectiveHandling;

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
     */
    public function testImportDirective()
    {
        // $directives = $this->directive()->all($themes);

        //$first = $directives['components'][0];

        //$this->directive()->load($first);
    }
}
