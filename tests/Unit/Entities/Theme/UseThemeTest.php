<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Foundation\ConfigKeeper;
use Maestriam\Samurai\Foundation\EnvHandler;

class UseThemeTest extends ThemeTestCase
{
    public function testUseExistingTheme()
    {
        $name  = 'bands/accept';
        $theme = new Theme($name);

        $ret = $theme->make()->use();

        $current = $this->currentTheme();

        $this->assertValidTheme($ret);
        $this->assertEquals($current, $name);
    }

    public function testUseInexistingTheme()
    {
        $name = 'bands/accept';
        
        $theme = new Theme($name);

        $this->expectException(ThemeNotFoundException::class);

        $theme->use();
    }
    
    private function currentTheme() : string
    {
        $key = $this->getEnvKey();

        $env = new EnvHandler();

        return $env->get($key);
    }
        
    private function getEnvKey() : string
    {
        $config = new ConfigKeeper();
        
        return $config->env();
    }
}