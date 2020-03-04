<?php

namespace Maestriam\Samurai\Tests\Unit;

use Tests\TestCase;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Models\Directive;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeIncludeTest extends TestCase
{
    use Themeable, WithFaker;

    protected $name;

    /**
     * Verifica se é possível criar um tema com um nome correto
     *
     * @return void
     */
    public function testSimpleIncludeName()
    {
        $theme = $this->faker->word();
        $name  = $this->faker->word(); 
        
        dump($theme);
        dump($name);

        $this->createInclude($theme, $name);
    }

    /**
     * Verifica se é possível criar um tema com um nome correto
     *
     * @return void
     */
    public function testSubfolderIncludeName()
    {
        $theme = $this->faker->word();
        $name  = 'dashboard/' . $this->faker->word(); 
        
        $this->createInclude($theme, $name);
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    private function createInclude($theme, $name)
    {
        $this->theme($theme)->findOrBuild();

        $include = $this->theme($theme)
                        ->include($name)
                        ->create();

        $this->assertInstanceOf(Directive::class, $include);
    }

    
}
