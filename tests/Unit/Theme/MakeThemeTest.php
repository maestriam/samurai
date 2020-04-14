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

    /**
     * Verifica se há falha ao criar um tema começando com números
     *
     * @return void
     */
    public function testNameStartNumbers()
    {
        $name = time() . $this->fakeTheme();

        $this->success($name);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testInvalidNameWithSpaces()
    {
        $theme  = 'vendor/nome errado';
        $author = $this->fakeAuthor(); 
        $desc   = $this->fakeDescription(); 

        $this->failure(INVALID_THEME_NAME_CODE, $theme);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testInvalidNameWithSpecialChars()
    {
        $theme  = 'vendor/crüe';
        $author = $this->fakeAuthor(); 
        $desc   = $this->fakeDescription(); 

        $this->failure(INVALID_THEME_NAME_CODE, $theme);
    }

    /**
     * Verifica se há sucesso ao criar um tema com letra
     * maiuscula ou minuscula
     *
     * @return void
     */
    public function testUpperCaseName()
    {
        $name   = strtoupper($this->fakeTheme());
        $author = $this->fakeAuthor(); 
        $desc   = $this->fakeDescription(); 

        $this->failure(INVALID_THEME_NAME_CODE, $name, $author, $desc);
    }

    /**
     * Verifica se há erro ao criar um tema com caracteres especiais
     *
     * @return void
     */
    public function testSpecialChars()
    {
        $name   = "sp&cal-ch@r$-t()&m&/tuhos-ü";
        $author = $this->fakeAuthor(); 
        $desc   = $this->fakeDescription(); 

        $this->failure(INVALID_THEME_NAME_CODE, $name, $author, $desc);
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