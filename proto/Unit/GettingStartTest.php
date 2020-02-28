<?php

namespace Maestriam\Samurai\Tests;

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

    protected $themeName = 'samurai';

    /**
     * Verifica se é possível criar um tema com um nome correto
     *
     * @return void
     */
    public function testCreateTheme()
    {
        $theme = $this->theme($this->themeName)->build();

        $this->assertInstanceOf(Theme::class, $theme);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCreateInclude()
    {
        $name = $this->faker->word();

        $include = $this->theme($this->themeName)
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
        $name = $this->faker->word();

        $component = $this->theme($this->themeName)
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
        $published = $this->theme($this->themeName)
                          ->publish();

        $this->assertTrue($published);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testUseTheme()
    {
        $current = $this->theme($this->themeName)->use();

        $this->assertTrue($current);
    }
}
