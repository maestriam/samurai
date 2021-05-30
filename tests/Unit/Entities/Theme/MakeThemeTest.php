<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Exceptions\ThemeExistsException;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeThemeTest extends ThemeTestCase
{
    /**
     * Verifica se consegue criar um tema com um vendor válido
     *
     * @return void
     */
    public function testCreateTheme()
    {
        $theme = new Theme('bands/ozzy');

        $theme = $theme->make();

        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertDirectoryExists($theme->paths()->root());
        $this->assertDirectoryExists($theme->paths()->source());   
        $this->assertDirectoryExists($theme->paths()->assets()); 
    } 
    
    /**
     * Verifica se consegue criar um tema já existe na base
     *
     * @return void
     */
    public function testCreateExistingTheme()
    {
        $theme1 = new Theme('bands/ozzy');
        $theme2 = new Theme('bands/ozzy');

        $this->expectException(ThemeExistsException::class);

        $theme1->make();
        $theme2->make();
    }
}