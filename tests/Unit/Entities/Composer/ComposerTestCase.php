<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Composer;

use Maestriam\Samurai\Entities\Composer;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

class ComposerTestCase extends TestCase
{
    public function testComposerInit()
    {
        $theme = new Theme('bands/vixen');

        $composer = new Composer($theme);

        $this->assertInstanceOf(Composer::class, $composer);
    }

    public function testInitComposerWithDescription()
    {        
        $description = 'my new theme';

        $theme = new Theme('bands/vixen');
        
        $composer = new Composer($theme, $description);

        $this->assertInstanceOf(Composer::class, $composer);
        $this->assertEquals($description, $composer->description());
    }
}