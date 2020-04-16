<?php

namespace Maestriam\Samurai\Tests\Unit\Directive;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;
use Maestriam\Samurai\Traits\Testing\ContestDirective;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeIncludeTest extends TestCase
{
    use WithFaker, Themeable, FakeValues, ContestDirective;

    public function testHappyPath()
    {
        $theme   = $this->fakeTheme();
        $include = $this->fakeInclude();
        
        $this->success($theme, $include);
    }
    
    public function testThemeNotFoundInclude()
    {
        $theme   = $this->fakeTheme() . time(); 
        $include = $this->fakeInclude();
        
        $this->failed(THEME_NOT_FOUND_CODE, $theme, $include);
    }

    public function testDuplicateInclude()
    {
        $theme   = $this->fakeTheme();
        $include = $this->fakeInclude();

        $this->theme($theme)
             ->findOrBuild()
             ->include($include)
             ->create();

        $this->failed(DIRECTIVE_EXISTS_CODE, $theme, $include);
    }

    public function testInvalidIncludeName()
    {
        $theme = $this->fakeTheme();
        
        $this->theme($theme)->findOrBuild();

        $includes = [
            '#invalid-name'
        ];

        foreach ($includes as $include) {
            $this->failed(INVALID_DIRECTIVE_NAME_CODE, $theme, $include);
        }
    }
}