<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Composer;

use Maestriam\Samurai\Entities\Composer;
use Maestriam\Samurai\Entities\Vendor;
use Maestriam\Samurai\Tests\TestCase;

class ComposerTestCase extends TestCase
{
    public function testComposerInit()
    {
        $vendor = new Vendor('bands/vixen');

        $composer = new Composer($vendor);

        $this->assertInstanceOf(Composer::class, $composer);
    }

    public function testInitComposerWithDescription()
    {
        $vendor = new Vendor('bands/vixen');

        $desc = 'my new theme';

        $composer = new Composer($vendor, $desc);

        $this->assertInstanceOf(Composer::class, $composer);
        $this->assertEquals($desc, $composer->description());
    }

    public function testSetDescription()
    {
        
    }
}