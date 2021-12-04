<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Vendor;

use Maestriam\Samurai\Entities\Vendor;
use Maestriam\Samurai\Tests\TestCase;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class VendorTestCase extends TestCase
{
    public function testVendorProperties()
    {
        $dist  = 'maestriam';
        $name  = 'samurai';
        
        $nspace  = ucfirst($dist) ."/". ucfirst($name);
        $package = $dist ."/". $name;

        $vendor = new Vendor($package);
        
        $this->assertIsString($vendor->name());
        $this->assertIsString($vendor->package());
        $this->assertIsString($vendor->namespace());
        $this->assertIsString($vendor->distributor());

        $this->assertEquals($vendor->name(), $name);
        $this->assertEquals($vendor->package(), $package);
        $this->assertEquals($vendor->namespace(), $nspace);
        $this->assertEquals($vendor->distributor(), $dist);
    }
}