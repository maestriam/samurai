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
        $theme = new Theme();
        
        $ret = $theme->vendor('bands/warrant');

        $this->assertInstanceOf(Theme::class, $ret);
    }  
    
    /**
     * Verifica se consegue recuperar o vendor do tema
     *
     * @return void
     */
    public function testGetVendor()
    {
        $package = 'bands/warrant';
        
        $theme = new Theme();    
            
        $theme->vendor($package);

        $this->assertThemeVendor($theme->vendor(), $package);        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testDefaultVendor()
    {
        $theme = new Theme();

        $vendor = $theme->vendor();
    }

    /**
     * Verifica se consegue definir o vendor no contructor do tema
     *
     * @return void
     */
    public function testSetVendorPassingConstructor()
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