<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\EnvHandler;

use Maestriam\Samurai\Foundation\EnvHandler;
use stdClass;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class GetEnvVariableTest extends EnvHandlerTestCase
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
     * Verifica se é possível recuperar um valor de uma variavel de ambiente inexistente
     * no arquivo     
     *
     * @return void
     */
    public function testGetEnvVariableInvalid()
    {
        $key = 'THEME_CURRENT_' . time();
        
        $handler = new EnvHandler();

        $this->assertNull($handler->get($key));
    }

    /**
     * Verifica se é possível tentar recuperar uma chave, sem passar o nome
     * dela na função get.
     * Por padrão, deve emitir um erro de argumento
     *
     * @return void
     */
    public function testGeWithtNullableKey()
    {   
        $handler = new EnvHandler();

        $this->expectException(\ArgumentCountError::class);
        $handler->get();
        
        $this->expectException(\ArgumentCountError::class);
        $handler->get(null);       
    }

    /**
      * Verifica se é possível tentar recuperar uma chave, passando 
     * tipos diferentes de string
     * Por padrão, deve emitir um ErrorException
     *
     * @return void
     */
    public function testGetWithInvalidTypeKey()
    {
        $this->expectException(\ErrorException::class);
        $handler->get([]);

        $this->expectException(\ErrorException::class);
        $handler->get(new stdClass());
    }
}