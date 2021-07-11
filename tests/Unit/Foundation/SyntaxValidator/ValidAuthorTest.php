<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\SyntaxValidator;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ValidAuthorTest extends SyntaxValidatorTestCase
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function testHappyPath()
    {
        $author = "Giu <giuguitar@gmail.com>";

        $this->assertValidAuthor($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testSurname()
    {
        $author = "Giu <giuguitar@gmail.com>";

        $this->assertValidAuthor($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testInvalidEmail()
    {
        $author = "Giu <!this-invalid-email@error.com>";

        $this->assertInvalidAuthor($author);
    }

    public function testInvalidAuthorNames()
    {
        $authors = [
            'MYXOMc <petra.wintheiser@gusikowski.info>'
        ];

        foreach ($authors as $author) {
            $this->assertInvalidAuthor($author);
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

        $this->assertInvalidAuthor($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testSpacesBetweenInfos()
    {
        $author = "Giu           <alot@spaces.com>";

        $this->assertValidAuthor($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testEmailWithExtension()
    {
        $author = "Giu <brasil@domain.com.br>";

        $this->assertValidAuthor($author);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testEmailStartsWithNumber()
    {
        $author = "Giu <123brasil@domain.com>";

        $this->assertValidAuthor($author);
    }
}
