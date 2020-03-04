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
class GettingStartTest extends TestCase
{
    use Themeable, WithFaker;

    protected $name;

    protected function setUp() : void
    {
        parent::setUp();

        $this->name = $this->faker->word();
    }

    /**
     * Verifica se é possível criar um tema com um nome correto
     *
     * @return void
     */
    public function testCreateTheme()
    {
        $theme = $this->theme($this->name)->build();

        $this->assertInstanceOf(Theme::class, $theme);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCreateInclude()
    {
        $this->theme($this->name)->findOrBuild();

        $name  = $this->faker->word();

        $include = $this->theme($this->name)
                        ->include($name)
                        ->create();

        $this->assertInstanceOf(Directive::class, $include);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testeCreateComponent()
    {
        $this->theme($this->name)->findOrBuild();

        $name  = $this->faker->word();

        $component = $this->theme($this->name)
                          ->component($name)
                          ->create();

        $this->assertInstanceOf(Directive::class, $component);

    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testPublishTheme()
    {
        $this->theme($this->name)->findOrBuild();

        $theme = $this->faker->word();

        $published = $this->theme($this->name)->publish();

        $this->assertTrue($published);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testUseTheme()
    {
        $this->theme($this->name)->findOrBuild();

        $current = $this->theme($this->name)->use();

        $this->assertTrue($current);
    }
}
