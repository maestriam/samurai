<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Component;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Tests\TestCase;

class ImportComponentTest extends TestCase
{
    public function testImportComponent()
    {
        $theme = $this->theme('bands/king-cobra')->findOrCreate();

        $component = $theme->component('musics/never-say-die')->create();

        $ret = $component->import();

        $this->assertInstanceOf(Component::class, $ret);
    }
}