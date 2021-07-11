<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Composer;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Composer;
use stdClass;

class LoadComposerTest extends ComposerTestCase
{
    public function testLoadComposer()
    {
        $theme = $this->theme('bands/rolling-stones');

        $theme->make();

        $file = $theme->paths()->root() . '/composer.json';
        
        $composer = new Composer($theme);

        $info = $composer->load()->info();

        $this->assertFileExists($file);
        $this->assertInstanceOf(stdClass::class, $info);
        $this->assertIsString($info->description);
        $this->assertIsArray($info->authors);
        $this->assertIsString($info->authors[0]->name);
        $this->assertIsString($info->authors[0]->email);
    }   
}