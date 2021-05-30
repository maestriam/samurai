<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Structure;
use Maestriam\Samurai\Entities\Vendor;
use Maestriam\Samurai\Tests\TestCase;

class StructureTestCase extends TestCase
{
    public function testInitStructure()
    {
        $vendor = new Vendor('bands/dio');

        $structure = new Structure($vendor);

        $this->assertObjectHasFunction($structure, 'public');
        $this->assertObjectHasFunction($structure, 'assets');
        $this->assertObjectHasFunction($structure, 'source');
    }
}
