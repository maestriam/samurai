<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;

/**
 * Testes de verificação de existência de tema
 */
class FindThemeTest extends ThemeTestCase
{
    /**
     * Verifica se retorna a instância de Theme, consegue recuperar os dados de um tema existente.  
     *
     * @return void
     */
    public function testGetExistingTheme()
    {
        $name = 'bands/lizzy-bourden';
        $theme1 = new Theme($name);
        
        $theme1->make();
        $theme2 = new Theme($name);        
        
        $ret = $theme2->find();
        
        $this->assertInstanceOf(Theme::class, $ret);
    }
    
    /**
     * Verifica se retorna nulo quando t
     *
     * @return void
     */
    public function testGetInexistingTheme()
    {
        $theme = new Theme('bands/lizzy-bourden');
        
        $ret = $theme->find();

        $this->assertNull($ret);
    }
}
