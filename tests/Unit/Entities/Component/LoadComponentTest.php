<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Component;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Tests\TestCase;

class LoadComponentTest extends TestCase
{
    public function testLoadComponent()
    {
        $theme = $this->theme('bands/king-cobra')->findOrCreate();

        $component = $theme->component('musics/never-say-die')->create();

        $ret = $component->load();

        $this->assertInstanceOf(Component::class, $ret);
    }
}