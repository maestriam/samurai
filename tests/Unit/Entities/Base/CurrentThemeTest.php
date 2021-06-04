<?php

namespace Maestriam\Samurai\Entities\Base;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;

class CurrentThemeTest extends TestCase
{
    /**
     * Verifica se consegue retornar o tema padrão do projeto ao defini-lo.  
     *
     * @return void
     */
    public function testCurrentTheme()
    {        
        $theme1 = new Theme('bands/dokken');
        $theme1->make()->use();       
        
        $base = new Base();
        $theme2 = $base->current();

        $this->assertEquals($theme1->package(), $theme2->package());
    }

    /**
     * Verifica se retorna nulo ao tentar recuperar o tema padrão do 
     * projeto, sem ter defindo nenhum tema.  
     *
     * @return void
     */
    public function testInexistingCurrentTheme() : void
    {
        $base = new Base();

        $theme = $base->current();

        $this->assertNull($theme);
    }
}