<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Vendor;

use Maestriam\Samurai\Entities\ViewComponent;
use Maestriam\Samurai\Tests\TestCase;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class ViewComponentTestCase extends TestCase
{
    /**
     * Tenta criar um componente simples e vincular um ViewComponent
     * ao arquivo.  
     *
     * @return  [type]  [return description]
     */
    public function testVendorProperties()
    {
        $name = 'view-component';         
        $theme = $this->theme('bands/molchat-doma');
        
        $theme->findOrCreate()->use();        
        $theme->component($name)->create();            

        $view = new ViewComponent();
        $file = $view->getView();

        $this->assertIsString($file);  
        $this->assertNotNull($file);
    }
}