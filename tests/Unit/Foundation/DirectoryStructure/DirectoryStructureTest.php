<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\EnvHandler;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\DirectoryStructure;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class DirectoryStructureTest extends TestCase
{
    /**
     * Instancia a classe de validação para ser testada
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
    }    

    /**
     * Verifica se consegue recuperar o caminho do diretório-base de temas do projeto.
     * Este caminho é definido no arquivo config.php.
     *
     * @return void
     */
    public function txestGetBasePath()
    {          
        $folder = base_path('sandbox/themes');

        config(['samurai.themes.folder' => $folder]);

        $structure = new DirectoryStructure();
             
        $base = $structure->base();

        $this->assertIsString($base);       
        $this->assertEquals($base, $folder);
    }

    /**
     * Verifica se consegue recuperar o caminho padrão do diretório-base de temas do projeto.
     * Este caminho é definido via código na ausência de 
     * configuração no config.php
     *
     * @return void
     */
    public function testGetDefaultBasePath()
    {
        config(['samurai.themes.folder' => null]);

        $default = base_path('themes');

        $structure = new DirectoryStructure();
     
        $base = $structure->base();

        $this->assertIsString($base);
        $this->assertEquals($base, $default);
    }
}