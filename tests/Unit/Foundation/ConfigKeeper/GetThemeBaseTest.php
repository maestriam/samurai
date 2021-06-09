<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\ConfigKeeper;

use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Foundation\ConfigKeeper;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class GetThemeBaseTest extends ConfigKeeperTestCase
{
    /**
     * Verifica se consegue recuperar o caminho do diretório-base 
     * de temas do projeto.  
     * 
     * Este caminho é definido no arquivo config.php.
     *
     * @return void
     */
    public function testGetBasePath()
    {          
        $folder = base_path('bands/kiss') . DS;
        $folder = FileSystem::folder($folder)->sanitize();

        $config = new ConfigKeeper();             

        $this->setThemeBase($folder);

        $this->assertConfigKey($config->base(), $folder);
    }

    /**
     * Verifica se consegue recuperar o caminho padrão do 
     * diretório-base de temas do projeto.  
     * 
     * Este caminho é definido via código na ausência de configuração 
     * no config.php
     * 
     * @return void
     */
    public function testGetDefaultBasePath()
    {        
        $this->setThemeBase(null);

        $default = base_path('themes') . DS;
        $default = FileSystem::folder($default)->sanitize();
        
        $config = new ConfigKeeper();  

        $this->assertConfigKey($config->base(), $default);
    }
}