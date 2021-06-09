<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Component;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Tests\TestCase;

class DirectivesFromThemeTest extends TestCase
{
    public function testDirectives()
    {
        $theme = $this->theme('bands/icon')->findOrCreate();

        $theme->component('musics/danger-calling')->create();
        $theme->component('musics/night-of-the-crime')->create();
        $theme->component('musics/missing')->create();

        $directives = $theme->directives();

        $this->assertIsArray($directives);

        foreach ($directives as $directive) {
            $this->assertInstanceOf(Component::class, $directive);
        }
    }
}