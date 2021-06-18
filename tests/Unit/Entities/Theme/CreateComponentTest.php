<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Tests\TestCase;

class CreateComponentTest extends TestCase
{
    public function testImportComponent()
    {
        $theme = $this->theme('bands/angra')->make();

        $component = $theme->component('musics/carry-on')->create();
        
        $this->assertInstanceOf(Component::class, $component);
    }
}