<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Includer;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Entities\Includer;
use stdClass;

class IncluderTestCase extends TestCase
{
    /**
     * Verifica se a instância de um novo include foi definida de maneira correta
     * e possui todas as suas funções básicas
     *
     * @return void
     */
    public function testInitInclude()
    {
        $theme = new Theme('bands/guns-n-roses');
        
        $sentence = 'tables/table';
        $include  = new Includer($theme, $sentence);

        $this->assertInstanceOf(Includer::class, $include);
        $this->assertDirectiveSentence($include, $sentence);
        $this->assertDirectiveType($include);
    }

    /**
     * Verifica se a sentença definida para a diretiva está correta
     *
     * @param Includer $include
     * @param string $sentence
     * @return void
     */
    protected function assertDirectiveSentence(Includer $include, string $sentence)
    {
        $this->assertIsString($include->sentence());
        $this->assertObjectHasFunction($include, 'sentence');
        $this->assertEquals($include->sentence(), $sentence);
    }
    
    /**
     * Verifica se o tipo definido para a diretiva está correta
     *
     * @param Includer $include
     * @return void
     */
    protected function assertDirectiveType(Includer $include)
    {
        $this->assertIsString($include->type());
        $this->assertEquals($include->type(), 'include');        
        $this->assertObjectHasFunction($include, 'type');
    }
    
    /**
     * Verifica se o alias para a diretiva está correta.  
     *
     * @param Includer $include
     * @return void
     */
    protected function assertAlias(Includer $include)
    {
        $this->assertInstanceOf(stdClass::class, $include->alias());
        $this->assertObjectHasAttribute('kebab', $include->alias());
        $this->assertObjectHasAttribute('camel', $include->alias());
    }
}