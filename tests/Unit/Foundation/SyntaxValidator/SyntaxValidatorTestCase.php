<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\SyntaxValidator;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\SyntaxValidator;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class SyntaxValidatorTestCase extends TestCase
{
    public function testInitTheme()
    {
        $validator = new SyntaxValidator();

        $this->assertObjectHasFunction($validator, 'author');
        $this->assertObjectHasFunction($validator, 'vendor');
    }

    /**
     * Contesta um teste para verificar se há retorno de sucesso
     *
     * @param mixed $vendor
     * @return void
     */
    protected function assertValidVendor($vendor)
    {
        $validator = new SyntaxValidator();

        $result = $validator->vendor($vendor);
        
        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /**
     * Contesta um teste para verificar se há retorno de falha
     *
     * @param mixed $vendor
     * @return void
     */
    protected function assertInvalidVendor($vendor)
    {
        $validator = new SyntaxValidator();

        $result = $validator->vendor($vendor);
        
        $this->assertIsBool($result);
        $this->assertFalse($result);
    }

    /**
     * Contesta um teste para verificar se há retorno de sucesso
     *
     * @param mixed $vendor
     * @return void
     */
    protected function assertValidAuthor($vendor)
    {
        $validator = new SyntaxValidator();

        $result = $validator->author($vendor);

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /**
     * Contesta um teste para verificar se há retorno de falha
     *
     * @param mixed $vendor
     * @return void
     */
    protected function assertInvalidAuthor($vendor)
    {
        $validator = new SyntaxValidator();

        $result = $validator->author($vendor);

        $this->assertIsBool($result);
        $this->assertFalse($result);
    }
}