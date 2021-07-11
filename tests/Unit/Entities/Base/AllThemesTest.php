<?php

namespace Maestriam\Samurai\Entities\Base;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Tests\TestCase;

class AllThemesTest extends TestCase
{
    public function testAllThemes()
    {
        $this->theme('bands/scorpions')->make();
        $this->theme('bands/judas-priest')->make();
        $this->theme('bands/twisted-sisters')->make();
     
        $base = new Base();
        
        $themes = $base->all();
        
        $this->assertIsArray($themes);
        $this->assertNotEmpty($themes);
    }
    
    public function testEmptyThemeBase()
    {
        $base = new Base();
        
        $themes = $base->all();
        
        $this->assertEmpty($themes);
    }
}