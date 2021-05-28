<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Exceptions\ThemeExistsException;

/**
 * Testes de verificação de existência de tema
 */
class ThemeExistenceTest extends ThemeTestCase
{
    /**
     * Verifica se o tema existe na base, depois do comando de criação
     *
     * @return void
     */
    public function testExistsTheme()
    {
        $theme = new Theme('bands/whitesnake');

        $theme->make();

        $exists = $theme->exists();
        
        $this->assertTrue($exists);
        $this->assertIsBool($exists);
    }
    
    /**
     * Verifica se o tema existe na base, sem ele não ter criado
     *
     * @return void
     */
    public function testNotExistsTheme()
    {
        $theme = new Theme('bands/white-znake');
        
        $exists = $theme->exists();

        $this->assertFalse($exists);
    }
}