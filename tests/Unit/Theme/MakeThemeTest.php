<?php

namespace Maestriam\Samurai\Tests\Unit\Theme;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;
use Maestriam\Samurai\Traits\Testing\ContestTheme;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeThemeTest extends TestCase
{
    use WithFaker, Themeable, FakeValues, ContestTheme;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testHappyPath() 
    {
        $theme  = $this->fakeTheme();
        $author = $this->fakeAuthor();
        $desc   = $this->fakeDescription();

        $this->success($theme, $author, $desc);
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function testWithoutAuthor()
    {
        $theme  = $this->fakeTheme();
        $desc   = $this->fakeDescription();
        
        $this->success($theme, null, $desc);
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function testWithoutDescription()
    {
        $theme  = $this->fakeTheme();
        $author = $this->fakeAuthor();

        $this->success($theme, $author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testOnlyThemeName()
    {
        $theme = $this->fakeTheme();

        $this->success($theme);
    }
    
    public function testValidVendoresNames()
    {
        $names = [
            time() . $this->fakeTheme()
        ];

        foreach ($names as $name) {
            $this->success($name);
        }
    }

    /**
     * Verifica uma lista de nomes incompatíveis com o 
     * formato "vendor/name"
     *
     * @return void
     */
    public function testInvalidVendorNames()
    {
        $names = [
            'vendor/nome errado',
            'vendor/crüe',
            'VENDOR/THEME',
            'sp&cal-ch@r$-t()&m&/tuhos-ü'
        ];

        $author = $this->fakeAuthor(); 
        $desc   = $this->fakeDescription();

        foreach ($names as $name) {
            $this->failure(INVALID_THEME_NAME_CODE, $name, $author, $desc);
        }
    }

    /**
     * Verifica se há erro ao criar um tema com caracteres especiais
     *
     * @return void
     */
    public function testAuthorWithSpecialChars()
    {
        $name   = $this->fakeTheme(); 
        $author = 'Anna Mädchen Mourão <ann@gmail.com>'; 
        $desc   = $this->fakeDescription(); 
        
        $this->failure(INVALID_AUTHOR_CODE, $name, $author, $desc);
    }
    
    /**
     * Verifica se há erro ao criar um tema com caracteres especiais
     *
     * @return void
     */
    public function testAuthorWithNoSpaces()
    {
        $name   = $this->fakeTheme(); 
        $author = 'Anna Kalodkova<ann@gmail.com>'; 
        $desc   = $this->fakeDescription(); 
        
        $this->failure(INVALID_AUTHOR_CODE, $name, $author, $desc);
    }

    /**
     * Verifica se há erro ao criar um tema com um e-mail 
     * com caracteres especiais e inválidos
     *
     * @return void
     */
    public function testInvalidEmailAuthor()
    {
        $name   = $this->fakeTheme();
        $author = 'Joe Foo <mäil@mail.com>';
        $desc   = $this->fakeDescription(); 
        
        $this->failure(INVALID_AUTHOR_CODE, $name, $author, $desc);
    }
}