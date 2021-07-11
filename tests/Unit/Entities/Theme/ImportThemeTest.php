<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;

class ImportThemeTest extends ThemeTestCase
{
    public function testImportTheme()
    {
        $name = 'bands/manowar';

        $theme1 = new Theme($name);
        
        $theme1->description('Hail to the Engaland')->make();
        
        $theme2 = new Theme($name);        

        $this->assertEquals($theme1->author(), $theme2->author());
        $this->assertEquals($theme1->package(), $theme2->package());
        $this->assertEquals($theme1->description(), $theme2->description());
        $this->assertEquals($theme1->paths()->root(), $theme2->paths()->root());
        $this->assertEquals($theme1->paths()->source(), $theme2->paths()->source());
    }
}