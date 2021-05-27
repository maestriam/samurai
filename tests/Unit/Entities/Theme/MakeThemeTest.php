<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Exceptions\ThemeExistsException;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeThemeTest extends ThemeTestCase
{
    public function testCreateTheme()
    {
        $theme = new Theme('bands/ozzy');

        $theme = $theme->make();

        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertDirectoryExists($theme->paths()->root());
        $this->assertDirectoryExists($theme->paths()->files());   
        $this->assertDirectoryExists($theme->paths()->assets()); 
    } 
    
    public function testCreateExistingTheme()
    {
        $theme1 = new Theme('bands/ozzy');
        $theme2 = new Theme('bands/ozzy');

        $this->expectException(ThemeExistsException::class);

        $theme1->make();
        $theme2->make();
    }

    public function testExistingTheme()
    {
        $theme = new Theme('bands/ozzy-osbourne');

        $theme->make();

        $this->assertIsBool($theme->exists());
        $this->assertTrue($theme->exists());
    }
}