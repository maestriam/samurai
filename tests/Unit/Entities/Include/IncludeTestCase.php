<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Include;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Entities\IncludeDirective;

class IncludeTestCase extends TestCase
{
    public function testInitInclude()
    {
        $theme = new Theme('bands/guns-n-roses');
        
        $sentence = 'tables/table';
        $include  = new IncludeDirective($theme, $sentence);

        $this->assertInstanceOf(IncludeDirective::class, $include);
        $this->assertDirectiveSentence($include, $sentence);
    }

    protected function assertDirectiveSentence(IncludeDirective $include, string $sentence)
    {
        $this->assertObjectHasFunction($include, 'sentence');
        $this->assertIsString($include->sentence());
        $this->assertEquals($include->sentence(), $sentence);
    }
}