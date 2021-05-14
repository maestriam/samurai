<?php

namespace Maestriam\Samurai\Tests\Foundation\SyntaxValidator;

use Tests\TestCase;
use Maestriam\Samurai\Foundation\SyntaxValidator;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ValidAuthorTest extends TestCase
{
    protected $valid;

    /**
     * Instancia a classe de validação para ser testada
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->valid = new SyntaxValidator();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testHappyPath()
    {
        $author = "Giu <giuguitar@gmail.com>";

        $this->success($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testSurname()
    {
        $author = "Giu <giuguitar@gmail.com>";

        $this->success($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testInvalidEmail()
    {
        $author = "Giu <!this-invalid-email@error.com>";

        $this->failure($author);
    }

    public function testInvalidAuthorNames()
    {
        $authors = [
            'MYXOMc <petra.wintheiser@gusikowski.info>'
        ];

        foreach ($authors as $author) {
            $this->failure($author);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testNameWithAccentures()
    {
        $author = "João Mädchen <foo@domain.com>";

        $this->failure($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testSpacesBetweenInfos()
    {
        $author = "Giu           <alot@spaces.com>";

        $this->success($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testEmailWithExtension()
    {
        $author = "Giu <brasil@domain.com.br>";

        $this->success($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testEmailStartsWithNumber()
    {
        $author = "Giu <123brasil@domain.com>";

        $this->success($author);
    }

    /**
     * Contesta um teste para verificar se há retorno de sucesso
     *
     * @param mixed $vendor
     * @return void
     */
    private function success($vendor)
    {
        $result = $this->valid->author($vendor);

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    /**
     * Contesta um teste para verificar se há retorno de falha
     *
     * @param mixed $vendor
     * @return void
     */
    private function failure($vendor)
    {
        $result = $this->valid->author($vendor);

        $this->assertIsBool($result);
        $this->assertFalse($result);
    }
}
