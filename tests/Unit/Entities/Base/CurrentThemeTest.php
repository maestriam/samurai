<?php

namespace Maestriam\Samurai\Entities\Base;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

class CurrentThemeTest extends TestCase
{
    public function testCurrentTheme()
    {
        $base = new Base();

        $theme1 = new Theme('bands/dokken');

        $theme1->make()->use();       
        
        $theme2 = $base->current();

        $this->assertEquals($theme1->package(), $theme2->package());
    }
}