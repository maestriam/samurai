<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class ThemeVendorTest extends TestCase
{
    /**
     * Verifica se consegue definir o vendor do tema
     *
     * @return void
     */
    public function testSetVendor()
    {
        $theme = new Theme();
        
        $ret = $theme->vendor('sandbox/theme');

        $this->assertInstanceOf(Theme::class, $ret);
    }  
    
    /**
     * Verifica se consegue recuperar o vendor do tema
     *
     * @return void
     */
    public function testGetVendor()
    {
        $theme  = new Theme();
        $vendor = 'sandbox/vendor';

        $theme->vendor($vendor);
        $ret = $theme->vendor();

        $this->assertIsString($ret);
        $this->assertEquals($vendor, $ret);
    }

    /**
     * Verifica se consegue definir o vendor no contructor do tema
     *
     * @return void
     */
    public function testSetVendorPassingConstructor()
    {
        $vendor = 'sandbox/vendor';
        $theme  = new Theme($vendor);

        $ret = $theme->vendor();

        $this->assertIsString($ret);
        $this->assertEquals($vendor, $ret);
    }
}