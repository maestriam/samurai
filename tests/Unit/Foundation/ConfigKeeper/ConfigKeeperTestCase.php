<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\ConfigKeeper;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\ConfigKeeper;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ConfigKeeperTestCase extends TestCase
{
    public function tearDown() : void
    {
        //
    }

    /**
     * Retorna o valor de env_key, vindo da configuração
     *
     * @return void
     */
    protected function getEnvKey()
    {
        return config('samurai.env_key'); 
    }

    /**
     * Apaga o registro de env_key, definido na configuração
     *
     * @return void
     */
    protected function eraseEnvKey()
    {
        config(['samurai.env_key' => null]);   
    }

    /**
     * Define o diretório base de temas nas configurações
     *
     * @param string $folder
     * @return void
     */
    protected function setThemeBase(string $folder = null)
    {
        config(['samurai.themes.folder' => $folder]);
    }

    /**
     * Verifica se a chave vinda das configurações está OK
     *
     * @param mixed $value
     * @param mixed $expected
     * @return void
     */
    protected function assertConfigKey($value, $expected)
    {
        $this->assertIsString($value);
        $this->assertEquals($value, $expected);
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