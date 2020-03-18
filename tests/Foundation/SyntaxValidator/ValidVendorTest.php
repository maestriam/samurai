<?php

namespace Maestriam\Samurai\Tests\Foundation\SyntaxValidator;

use Tests\TestCase;
use Maestriam\Samurai\Foundation\SyntaxValidator;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ValidVendorTest extends TestCase
{
    protected $valid;

    /**
     * Instancia a classe de validação para ser testada
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->valid = new SyntaxValidator();
    }

    /**
     * Verifica se há sucesso ao passar um vendor/theme válido
     *
     * @return void
     */
    public function testValidVendor()
    {
        $vendor = 'vendor/theme';
        
        $this->success($vendor);
    }
    
    /**
     * Verifica se há sucesso ao passar um vendor/theme 
     * com traços
     *
     * @return void
     */
    public function testVendorWithDashes()
    {
        $vendor = 'my_vendor-name/my_theme-name';
        
        $this->success($vendor);
    }
    
    /**
     * Verifica se há erro ao passar um vendor/theme com 
     * carácteres especiais
     *
     * @return void
     */
    public function testVendorWithAccentuation()
    {
        $vendor = 'vendör/variação';
        
        $this->failure($vendor);
    }

    /**
     * Verifica se há erro ao passar um vendor/theme com 
     * carácteres especiais
     *
     * @return void
     */
    public function testVendorWithSpecialChars()
    {
        $vendor = 'vendo!,/asdq#q3sd';
        
        $this->failure($vendor);
    }

    /**
     * Verifica se há erro ao passar um vendor/theme com 
     * letras maiúsculas
     *
     * @return void
     */
    public function testUpperCase()
    {
        $vendor = 'VENDOR/NAME';

        $this->failure($vendor);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testThemeStartWithNumbers()
    {
        $vendor = 'vendor/123theme';

        $this->success($vendor);
    }

    /**
     * Contesta um teste para verificar se há retorno de sucesso
     *
     * @param mixed $vendor
     * @return void
     */
    private function success($vendor)
    {
        $result = $this->valid->vendor($vendor);
        
        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /**
     * Contesta um teste para verificar se há retorno de sucesso
     *
     * @param mixed $vendor
     * @return void
     */
    private function failure($vendor)
    {
        $result = $this->valid->vendor($vendor);
        
        $this->assertIsBool($result);
        $this->assertFalse($result);
    }
}