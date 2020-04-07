<?php

namespace Maestriam\Samurai\Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeTesting;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeIncludeTest extends TestCase
{
    use Themeable, ThemeTesting, WithFaker;

    protected $name;

    public function setUp() : void
    {
        $this->setConsts();
    }

    /**
     * Verifica se há sucesso ao criar um include com um nome correto
     *
     * @return void
     */
    public function testHappyPath()
    {
        $name = $this->includeName();

        $this->success($name);
    }

    /**
     * Verifica se há sucesso ao criar um include com um nome com traços
     *
     * @return void
     */
    public function testNameWithDashes()
    {
        $name = 'my-short-include-' . time();

        $this->success($name);
    }

    /**
     * Verifica se há sucesso ao criar um include
     *
     * @return void
     */
    public function testNameStartsWithNumber()
    {
        $name = time();

        $this->failure($name, INVALID_DIRECTIVE_NAME);
    }

    /**
     * Verifica se há erro ao tentar criar um include com 
     * nome com caracteres especiais
     * 
     * @return void
     */
    public function testNameWithSpecialChars()
    {
        $name = 'm%-!ncl#d&-n@me';

        $this->failure($name, INVALID_DIRECTIVE_NAME);
    }

    /**
     * Verifica se há sucesso ao tentar criar um include com
     * nome com letras maiusculas
     *
     * @return void
     */
    public function testUppercaseName()
    {
        $name = strtoupper($this->themeName());

        $this->success($name);
    }
    
    /**
     * Verifica se há sucesso ao criar um include com um nome correto
     * e uma subpasta correta
     *
     * @return void
     */
    public function testSubfolderIncludeName()
    {
        $name  = 'dashboard/' . $this->includeName();

        $this->success($name);
    }
    
    /**
     * Verifica se há sucesso ao criar um include com um sub-pasta
     *
     * @return void
     */
    public function testDashedNameWithSubfolder()
    {
        $name = 'subfolder/rmy-short-include-' . time();

        $this->success($name);
    }

    /**
     * Verifica se há sucesso ao criar uma diretiva começando com
     * uma pasta com um números 
     *
     * @return void
     */
    public function testFolderStartsWithNumber()
    {
        $name = time() . '/' . $this->includeName();

        $this->success($name);
    }

    public function testFolderWithSpace()
    {
        $name = 'folder with space/' . $this->includeName();

        $this->success($name);
    }


    public function testUppercaseFolder()
    {
        $name = 'Diretory-Uppercase/' . $this->includeName();

        $this->success($name);
    }

    /**
     * Verifica se houve um retorno de sucesso e garante
     * que todas as sua integridades estejam garantidas
     *
     * @param mixed $name
     * @return void
     */
    private function success($name, $debug = false)
    {
        $theme = $this->themeName();

        $this->theme($theme)->findOrBuild();

        $include = $this->theme($theme)->include($name)->create();

        $this->contestObject($include);
        $this->contestTheme($include->theme);

        if ($debug) dd($include);
    }

    /**
     * Função pae
     *
     * @param mixed $name
     * @param integer $index
     * @return void
     */
    private function failure($name, int $index, $debug = false)
    {
        $class = $this->getErrorClass($index);
        
        $this->expectException($class);

        $theme = $this->themeName();
        
        $this->theme($theme)->findOrBuild();
        
        $include = $this->theme($theme)->include($name)->create();
        
        if ($debug) dd($include);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function contestObject($directive)
    {
        $this->assertInstanceOf(Directive::class, $directive);
        
        $this->assertObjectHasAttribute('name',     $directive);
        $this->assertObjectHasAttribute('sentence', $directive);
        $this->assertObjectHasAttribute('type',     $directive);
        $this->assertObjectHasAttribute('theme',    $directive);
        $this->assertObjectHasAttribute('path',     $directive);
        $this->assertObjectHasAttribute('alias',    $directive);
        $this->assertObjectHasAttribute('folder',   $directive);
        $this->assertObjectHasAttribute('filename', $directive);
    }
    
    private function contestTheme($theme)
    {
        $this->assertInstanceOf(Theme::class, $directive);
    }

    private function contestFilename($theme)
    {
        $this->assertInstanceOf(Theme::class, $directive);
    }
}
