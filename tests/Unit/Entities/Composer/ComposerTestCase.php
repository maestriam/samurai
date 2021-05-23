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
        $description = 'my new theme';
        $vendor = new Vendor('bands/vixen');
        $composer = new Composer($vendor, $description);

        $this->assertInstanceOf(Composer::class, $composer);
        $this->assertEquals($description, $composer->description());
    }
}