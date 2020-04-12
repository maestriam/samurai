<?php

namespace Maestriam\Samurai\Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;
use Maestriam\Samurai\Models\Theme;
use Illuminate\Support\Facades\Config;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\ThemeTesting;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeThemeTest extends TestCase
{
    use Themeable, ThemeTesting, WithFaker;

    protected $name;

    public function setUp() : void
    {   
        $this->setConsts();
    }

    /**
     * Verifica se há sucesso ao criar um tema com um nome correto
     *
     * @return void
     */
    public function testHappyPath()
    {
        $name = $this->themeName();

        $this->success($name);
    }

    /**
     * Verifica se há falha ao criar um tema começando com números
     *
     * @return void
     */
    public function testNameStartNumbers()
    {
        $name = time() . $this->themeName();

        $this->failure($name, INVALID_THEME_NAME);
    }

    /**
     * Verifica se há sucesso ao criar um tema com letra
     * maiuscula ou minuscula
     *
     * @return void
     */
    public function testUpperCaseName()
    {
        $name = strtoupper($this->themeName());

        $this->success($name);
    }

    /**
     * Verifica se há erro ao criar um tema com caracteres especiais
     *
     * @return void
     */
    public function testSpecialChars()
    {
        $name = "sp&c/al-ch@r$-t()&m&";

        $this->failure($name, INVALID_THEME_NAME);
    }

    
}
