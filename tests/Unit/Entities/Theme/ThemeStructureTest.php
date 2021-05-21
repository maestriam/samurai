<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;

class ThemeStructureTest extends ThemeTestCase
{
    /**
     * Verifica se retorna o 
     *
     * @return void
     */
    public function testFilesPath()
    {
        $theme = new Theme('sandbox/local');

        $this->assertPathString($theme->paths()->files());
    }    
    
    public function testAssetPath()
    {
        $theme = new Theme('sandbox/local');
        
        $this->assertPathString($theme->paths()->assets());
    }
    
    public function testPublicPath()
    {
        $theme = new Theme('sandbox/local');        
        
        $this->assertPathString($theme->paths()->public());
    }
    
    private function assertPathString(string $path)
    {
        $dbSlashes = '//';
        $dbInvSlashes = '\\\\';
        $dbCrossSlashes = '\/';
        $dbInvCrossSlashes = '/\\';

        $this->assertIsString($path);
        $this->assertStringNotContainsString($dbSlashes, $path);
        $this->assertStringNotContainsString($dbInvSlashes, $path);
        $this->assertStringNotContainsString($dbCrossSlashes, $path);
        $this->assertStringNotContainsString($dbInvCrossSlashes, $path);
    }
}