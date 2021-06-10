<?php

namespace Maestriam\Samurai\Entities;

use stdClass;
use Maestriam\Samurai\Entities\Foundation;

class Wizard extends Foundation
{
    /**
     * Instância com as regras de negócio sobre o vendor
     */
    private Vendor $vendorInstance;    

    /**
     * Instância com as regras de negócio sobre o autor
     */
    private Author $authorInstance;
    
    public function __construct()
    {
        $this->setVendor()->setAuthor();
    }

    /**
     * Retorna a pergunta sobre o nome do tema para ser criado.   
     * Por padrão, retorna o vendor/nome-do-projeto como resposta.
     * 
     * @return object
     */
    public function theme() : object
    {
        $package = $this->vendor()->package();

        $question = sprintf('Name (<vendor/name>) [%s]', $package);

        return $this->question($question, $package);
    }

    /**
     * Retorna a pergunta sobre a descrição do tema para ser criado.    
     * Por padrão, retorna o vendor/nome-do-projeto como resposta.
     *
     * @return object
     */
    public function description() : object
    {
        $description = $this->config()->description();
        
        $question = sprintf("Description [%s]", $description);

        return $this->question($question, $description);
    }

    /**
     * Retorna a pergunta sobre o nome e e-mail do autor do tema.      
     * Por padrão, retorna o nome e e-email definido no config do pacote.  
     *
     * @return object
     */
    public function author() : object
    {
        $author = $this->defaultAuthor()->signature();

        $question = sprintf('Author [%s]', $author);

        return $this->question($question, $author);
    }

    /**
     * Retorna a pergunta de confirmação da criação do tema, 
     * com uma prévia de como irá ficar o composer.json.  
     *
     * @param string $vendor
     * @param string $author
     * @param string $desc
     * @return object
     */
    public function confirm(string $vendor, string $author, string $desc) : object
    {
        $theme = new Theme($vendor);

        $theme->author($author)->description($desc);

        $preview = $theme->preview();

        $question = 'Confirm? '. PHP_EOL . $preview;

        return $this->question($question, false);
    }

    /**
     * Retorna o vendor padrão da aplicação
     *
     * @return Vendor
     */
    private function vendor() : Vendor
    {
        return $this->vendorInstance;
    }
    
    /**
     * Define o vendor padrão da aplicação
     *
     * @return Wizard
     */
    private function setVendor() : Wizard
    {
        $this->vendorInstance = new Vendor();

        return $this;
    }

    /**
     * Retorna um autor padrão para a criação do tema
     *
     * @return string
     */
    private function defaultAuthor() : Author
    {
        return $this->authorInstance;
    }
    
    /**
     * Define o autor padrão da aplicação
     *
     * @return Wizard
     */
    private function setAuthor() : Wizard
    {
        $this->authorInstance = new Author();

        return $this;
    }

    private function question(string $quest, mixed $default) : object
    {
        return (object) [
            'ask'     => $quest,
            'default' => $default
        ];
    }
}
