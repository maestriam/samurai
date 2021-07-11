<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\ConfigKeeper;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\ConfigKeeper;
use Maestriam\Samurai\Tests\Unit\Foundation\ConfigKeeper\ConfigKeeperTestCase as ConfigKeeperConfigKeeperTestCase;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class GetPublisheableFolderTest extends ConfigKeeperTestCase
{
    /**
     * Tenta recuperar o nome do diretório de assets, 
     * que será publicado no diretório "public/' do projeto.  
     *
     * @return void
     */
    public function testGetPublishableFolder()
    {
        $config = $this->getConfigKeeper();

        $assets = $config->publishable();

        $this->assertIsString($assets);        
    }
}