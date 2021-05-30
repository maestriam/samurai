<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\ConfigKeeper;

use Maestriam\Samurai\Foundation\ConfigKeeper;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class GetEnvKeyTest extends ConfigKeeperTestCase
{
    /**
     * Tenta recuperar a chave que será inserida
     * no arquivo de ambiente
     *
     * @return void
     */
    public function testGetEnvKey()
    {
        $envkey = $this->getEnvKey();        
        $config = new ConfigKeeper();

        $this->assertIsString($config->env());
        $this->assertEquals($envkey, $config->env());
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
        $this->eraseEnvKey();

        $envkey = 'CURRENT_THEME';        
        $config = new ConfigKeeper();

        $this->assertIsString($config->env());
        $this->assertEquals($envkey, $config->env());
    }
}