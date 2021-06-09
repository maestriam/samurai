<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;

class LoadThemeTest extends ThemeTestCase
{
    public function testLoadTheme()
    {
        $theme = $this->theme('bands/running-wild')->findOrCreate();
        
        $theme->include('musics/raise-your-fist')->create();
        $theme->include('musics/under-jolly-roger')->create();
        
        $ret = $theme->load();

        $this->assertInstanceOf(Theme::class, $ret);
    }
}