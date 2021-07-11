<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Vendor;
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
        $theme = new Theme('bands/warrant');
        
        $this->assertInstanceOf(Vendor::class, $theme->vendor());
    }  
    
    /**
     * Verifica se consegue recuperar o vendor do tema
     *
     * @return void
     */
    public function testGetVendorPackage()
    {
        $package = 'bands/warrant';
        
        $theme = new Theme($package);        

        $this->assertThemeVendor($theme->vendor(), $package);        
    }

    /**
     * Verifica se as informações do vendor, definidas no tema,
     * foram criadas com sucesso
     *
     * @param mixed $vendor
     * @param mixed $package
     * @return void
     */
    private function assertThemeVendor($vendor, $package)
    {
        $this->assertInstanceOf(Vendor::class, $vendor);
        $this->assertEquals($vendor->package(), $package);
    }
}