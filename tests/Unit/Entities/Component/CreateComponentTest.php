<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Component;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
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
    
    public function testExistingComponent()
    {
        $theme = $this->theme('bands/metallica');

        $component1 = new Component($theme, 'integrants/kirk');
        $component2 = new Component($theme, 'integrants/kirk');

        $this->expectException(DirectiveExistsException::class);

        $component1->create();
        $component2->create();
    }
}