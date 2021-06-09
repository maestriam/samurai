<?php

namespace Maestriam\Samurai\Tests\Unit\Providers;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Providers\LoadThemesServiceProvider;
use Maestriam\Samurai\Tests\TestCase;

class LoadThemesServiceProviderTest extends TestCase
{
    public function testService()
    {
        $theme = $this->theme('bands/heavens-gate');            
        
        $theme->findOrCreate();
        
        $theme->include('musics/living-in-histeria')->create();
        $theme->component('musics/rising-sun')->create();

        $theme->use();

        $provider = $this->app->register(LoadThemesServiceProvider::class);

        $this->assertInstanceOf(LoadThemesServiceProvider::class, $provider);
    }
}