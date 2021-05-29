<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Include;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Entities\IncludeDirective;

class IncludeTestCase extends TestCase
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
        $include  = new IncludeDirective($theme, $sentence);

        $this->assertInstanceOf(IncludeDirective::class, $include);
        $this->assertDirectiveSentence($include, $sentence);
        $this->assertDirectiveType($include);
    }

    /**
     * Verifica se a sentença definida para a diretiva está correta
     *
     * @param IncludeDirective $include
     * @param string $sentence
     * @return void
     */
    protected function assertDirectiveSentence(IncludeDirective $include, string $sentence)
    {
        $this->assertIsString($include->sentence());
        $this->assertObjectHasFunction($include, 'sentence');
        $this->assertEquals($include->sentence(), $sentence);
    }
    
    protected function assertDirectiveType(IncludeDirective $include)
    {
        $this->assertIsString($include->type());
        $this->assertEquals($include->type(), 'include');        
        $this->assertObjectHasFunction($include, 'type');
    }
}