<?php

namespace Maestriam\Samurai\Tests\Foundation\SyntaxValidator;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ValidVendorTest extends SyntaxValidatorTest
{
    /**
     * Verifica se há sucesso ao passar um vendor/theme válido
     *
     * @return void
     */
    public function testValidVendor()
    {
        $vendor = 'vendor/theme';
        
        $this->assertValidVendor($vendor);
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
        
        $this->assertValidVendor($vendor);
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
        
        $this->assertInvalidVendor($vendor);
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
        
        $this->assertInvalidVendor($vendor);
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

        $this->assertInvalidVendor($vendor);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testThemeStartWithNumbers()
    {
        $vendor = 'vendor/123theme';

        $this->assertValidVendor($vendor);
    }
}