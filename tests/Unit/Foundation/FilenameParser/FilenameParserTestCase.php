<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\FilenameParser;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\FilenameParser;
use stdClass;

class FilenameParserTestCase extends TestCase
{
    /**
     * Verifica se consegue recuperar o nome do arquivo e seu diretório,
     * dado um caminho contendo o nome do arquivo e seus sub-diretórios
     *
     * @bug O parser somente identificar caminhos com "/". 
     * Caso colocarmos, \ ele não consegue interpretar
     * 
     * @bug Quando retorna a string da pasta não está colocando a / no final.
     * Ex. 
     * Errado: diretorio/diretorio. 
     * Certo: diretorio/diretorio/
     * 
     * @return void
     */
    public function testParseFilenameWithFolders()
    {
        $folder = 'table/includes/';
        $name   = 'table-include.blade.php';
        $file   = $folder . $name;
        
        $parser = new FilenameParser();
        $info   = $parser->filename($file);
        
        $this->assertInstanceOf(stdClass::class, $info);
        $this->assertFileName($info, $name);
        $this->assertFolderName($info, 'table\\includes'); //bug
    }

    /**
     * Verifica se consegue recuperar apenas o nome do arquivo,
     * dado um caminho contendo o apenas nome do arquivo
     *
     * @return void
     */
    public function testParseFilenameWithoutFolder()
    {
        $file = 'table-include.blade.php';

        $parser = new FilenameParser();
        $info   = $parser->filename($file);

        $this->assertInstanceOf(stdClass::class, $info);
        $this->assertFileName($info, $file);
        $this->assertFolderName($info, '');
    }

    protected function assertFileName($info, string $name)
    {        
        $this->assertObjectHasAttribute('name', $info);
        $this->assertEquals($info->name, $name);
    }
    
    protected function assertFolderName($info, string $folder)
    {
        $this->assertObjectHasAttribute('folder', $info);
        $this->assertEquals($info->folder, $folder); 
    }
}