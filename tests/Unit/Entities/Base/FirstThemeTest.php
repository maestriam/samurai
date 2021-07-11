<?php

namespace Maestriam\Samurai\Entities\Base;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

class FirstThemeTest extends TestCase
{
    public function testGetFirstTheme()
    {
        $fst = 'bands/alan-parsons';
        $snd = 'bands/black-sabbath';
        $trd = 'bands/deep-purple';

        $this->theme($trd)->make();
        $this->theme($fst)->make();
        $this->theme($snd)->make();

        $base = new Base();

        $theme = $base->first();

        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertEquals($theme->package(), $fst);
    }
}