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

    /**
     * Deve retornar o nome do arquivo no formato <vendo>/<theme>::<path>
     * mesmo utilizando separador de diretório do tipo Windows (\)
     *
     * @return void
     */
    public function testBladeNameWithWindowsSeparator()
    {        
        $DS = '\\';
        
        $nominator = new FileNominator();

        $expected = 'Bands/Cauldron::src.musics.tears-have-come';
        $received = $nominator->blade("Bands/Cauldron", "src\\musics\\tears-have-come", $DS);        

        $this->assertEquals($expected, $received);
    }

    /**
     * Deve retornar o nome do arquivo no formato <vendo>/<theme>::<path>
     * mesmo utilizando separador de diretório do tipo Windows (\)
     *
     * @return void
     */
    public function testBladeNameWithUnixSeparator()
    {        
        $DS = '/';
        
        $nominator = new FileNominator();

        $expected = 'Bands/Cauldron::src.musics.tears-have-come';
        $received = $nominator->blade("Bands/Cauldron", "src/musics/tears-have-come", $DS);        

        $this->assertEquals($expected, $received);
    }
}