<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\FilenameParser;

use stdClass;
use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\DirectiveParser;

class GetInfoFromFileTest extends TestCase
{
    public function testGetInfoFromFilename()
    {        
        $theme  = $this->theme('bands/blind-guardian')->findOrCreate();
        $parser = new DirectiveParser($theme);
        
        $component = $theme->component('musics/bards-song')->create();

        $file = $component->path();        
        $info = $parser->parse($file)->toObject();

        $this->assertInstanceOf(stdClass::class, $info);
        $this->assertEquals($component->sentence(), $info->sentence);
    }
}