<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\EnvHandler;

use stdClass;
use TypeError;
use ArgumentCountError;
use Maestriam\Samurai\Foundation\EnvHandler;
use Maestriam\Samurai\Tests\TestCase;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class GetEnvVariableTest extends TestCase
{
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

        $this->expectException(ArgumentCountError::class);

        /**
         * @disregard P1006 Supressão de erro de tipagem. 
         */
        $handler->get();

        /**
         * @disregard P1006 Supressão de erro de tipagem. 
         */
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
        $handler = new EnvHandler();

        $this->expectException(TypeError::class);

        /**
         * @disregard P1006 Supressão de erro de tipagem. 
         */
        $handler->get([]);

        /**
         * @disregard P1006 Supressão de erro de tipagem. 
         */
        $handler->get(new stdClass());
    }

    public function tearDown(): void
    {
        $handler = new EnvHandler();
        $handler->set('THEME_CURRENT', '');
    
        restore_error_handler();
        restore_exception_handler();
        
        parent::tearDown();
    }
}