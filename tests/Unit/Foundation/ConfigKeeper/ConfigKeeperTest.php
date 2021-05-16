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
     * Tenta recuperar a chave que será inserida
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

    /**
     * Verifica se consegue pegar env_key caso não esteja definida
     * no arquivo de configuração do pacote.
     * Por padrão, deve retornar o CURRENT_THEME
     *
     * @return void
     */
    public function testDefaultGetEnvKey()
    {
        $env = 'CURRENT_THEME';        
        $config = new ConfigKeeper();

        $this->assertIsString($config->env());
        $this->assertEquals($env, $config->env());
    }

    /**
     * Verifica se consegue pegar a descrição padrão do tema
     *
     * @return void
     */
    public function testGetDescription()
    {
        $desc = config('samurai.description');        
        $config = new ConfigKeeper();

        $this->assertIsString($config->description());
        $this->assertEquals($desc, $config->description());
    }
}