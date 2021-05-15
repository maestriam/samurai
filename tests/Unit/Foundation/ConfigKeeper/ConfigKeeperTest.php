<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\ConfigKeeper;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\ConfigKeeper;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ConfigKeeperTest extends TestCase
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
     * Verifica se consegue recuperar a chave que deve ser inserida
     * no arquivo de ambiente
     *
     * @return void
     */
    public function testGetEnvKey()
    {
        $env = config('samurai.env_key');
        
        $config = new ConfigKeeper();

        $this->assertIsString($config->env());
        $this->assertEquals($env, $config->env());
    }
}