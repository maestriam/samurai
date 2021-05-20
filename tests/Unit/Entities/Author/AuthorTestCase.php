<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Vendor;

use Maestriam\Samurai\Entities\Author;
use Maestriam\Samurai\Foundation\ConfigKeeper;
use Maestriam\Samurai\Tests\TestCase;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class AuthorTestCase extends TestCase
{
    /**
     * Testa se a classe retorna as propriedades básicas do autor
     * com o tipo correto
     *
     * @return void
     */
    public function testAuthorProperties()
    {        
        $signture = 'Giuliano Sampaio <sampaio.giuliano@gmail.com>';
        
        $author = new Author();

        $author->set($signture);

        $this->assertAuthorProperties($author);
    }   

    /** 
     * Testa se consegue carregar as informações do autor definido
     * no arquivo de configuração do pacote
     *
     * @return void
     */
    public function testLoadDefaultAuthor()
    {
        $author = new Author();
        
        $default = $author->default();

        $this->assertDefaultAuthor($default);
        
    } 

    /**
     * Te
     *
     * @return void
     */
    private function assertAuthorProperties(Author $author)
    {
        $this->assertIsString($author->name());
        $this->assertIsString($author->email());
    }

    /**
     * Undocumented function
     *
     * @param Author $author
     * @return void
     */
    private function assertDefaultAuthor(Author $author)
    {
        $config = new ConfigKeeper();
        $default = $config->author();

        $this->assertEquals($default->name, $author->name());
        $this->assertEquals($default->email, $author->email());
    }
}