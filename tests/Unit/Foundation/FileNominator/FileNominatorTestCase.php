<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\FileNominator;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\FileNominator;

/**
 * Testes de funcionalidades básicas para regras de nomeação de arquivos
 * dentro do tema
 */
class FileNominatorTestCase extends TestCase
{
    /**
     * Verifica se retorna o nome da diretiva 
     *
     * @return void
     */
    public function testIncludeName()
    {        
        $type = 'include';        
        $name = 'table';        

        $nominator = new FileNominator();
        $directive = $nominator->directive($name, $type);

        $expected  = "$name-$type";

        $this->assertIsString($directive);
        $this->assertEquals($expected, $directive);
    }
}