<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Component;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

class MakeComponentTest extends TestCase
{
    public function testInitComponent()
    {
        $theme = new Theme('bands/metallica');

        $component = new Component($theme, 'integrants/hetfield');

        $file = $component->create();

        $this->assertFileExists($file->path());
    }
}