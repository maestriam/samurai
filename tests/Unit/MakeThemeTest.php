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
        $name  = $this->themeName();

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

    /**
     * Testa se o tema foi criado corretamente e todos os seus 
     * atributos estão retornando de forma correta
     *
     * @param mixed $name
     * @return void
     */
    private function success($name)
    {
        $theme = $this->theme($name)->build();

        $this->contestObject($theme);
        $this->contestPath($theme->path);
        $this->contestName($theme->name);
        $this->contestNamespace($theme->namespace);
    }

    /**
     * Testa se há uma exception por erro de nome inválido
     *
     * @param mixed $name
     * @return void
     */
    private function failure($name, int $index)
    {
        $class = $this->getErrorClass($index);

        $this->expectException($class);

        $this->theme($name)->build();
    }   

    /**
     * Testa se o objeto do tema tem todos os atributos definidos
     * corretamente
     *
     * @param mixed $theme
     * @return void
     */
    private function contestObject($theme)
    {
        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertObjectHasAttribute('path', $theme);
        $this->assertObjectHasAttribute('name', $theme);
        $this->assertObjectHasAttribute('namespace', $theme);
    }

    /**
     * Testa se o nome do tema foi definido corretamente
     *
     * @param mixed $name
     * @return void
     */
    private function contestName($name)
    {
        $lower = strtolower($name);

        $this->assertStringContainsString($lower, $name, '', true);
    }

    /**
     * Testa se o caminho do tema foi criado corretamente e
     * se está acessível para leitra/escrita
     *
     * @param mixed $path
     * @return void
     */
    private function contestPath($path)
    {
        $this->assertIsString($path);
        $this->assertDirectoryExists($path);
        $this->assertDirectoryIsReadable($path);
        $this->assertDirectoryIsWritable($path);
    }

    /**
     * Testa se o namespace do tema, para chamada no Laravel, 
     * está criado de maneira correta
     *
     * @param mixed $namespace
     * @return void
     */
    private function contestNamespace($namespace)
    {
        $prefix  = Config::get('Samurai::prefix');
        $pattern = "/$prefix/";

        $this->assertRegExp($pattern, $namespace);
    }
}
