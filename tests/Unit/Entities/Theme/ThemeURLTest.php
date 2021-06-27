<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Foundation\ConfigKeeper;
use Maestriam\Samurai\Foundation\EnvHandler;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ThemeURLTest extends ThemeTestCase
{
    public function testThemeUrl()
    {
        $name  = 'bands/edguy';
        $theme = $this->theme($name)->findOrCreate();
        
        $expected = $this->getUrl($name);
        $actual   = $theme->url();

        $this->assertEquals($expected, $actual);
    }

    public function testUrlFileFromTheme()
    {
        $name  = 'bands/edguy';
        $file  = 'js/index.js';
        $theme = $this->theme($name)->findOrCreate();

        $expected = $this->getUrl($name, $file);
        $actual   = $theme->url($file);

        $this->assertEquals($expected, $actual);
    }

    public function getUrl($theme, $file = null)
    {
        $public = $this->getPublishable();
        $domain = $this->registerDomain();

        $file =  '/' . $file ?? '';

        return sprintf("%s/%s/%s%s", $domain, $public, $theme, $file);
    }

    private function registerDomain() : string
    {
        $env = new EnvHandler();

        $domain = 'http://localhost:8000';

        $env->set('APP_URL', $domain);

        return $domain;
    }

    private function getPublishable() : string
    {
        $config = new ConfigKeeper();

        return $config->publishable();
    }
}