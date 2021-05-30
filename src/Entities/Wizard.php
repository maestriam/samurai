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
    
    public function __construct()
    {
        $this->setVendor();
    }

    /**
     * Retorna a pergunta sobre o nome do tema para ser criado.   
     * Por padrão, retorna o vendor/nome-do-projeto como resposta.
     * 
     * @return object
     */
    public function theme() : object
    {
        $package  = $this->vendor()->package();
        $question = sprintf('Name (<vendor/name>) [%s]', $package);

        return (object) [
            'ask'     => $question,
            'default' => $package
        ];
    }

    /**
     * Retorna a pergunta sobre a descrição do tema para ser criado.    
     * Por padrão, retorna o vendor/nome-do-projeto como resposta.
     *
     * @return void
     */
    public function description() : object
    {
        $description = $this->config()->description();
        $question    = sprintf("Description [%s]", $description);

        return (object) [
            'ask'     => $question,
            'default' => $description
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function author() : object
    {
        $author = $this->defaultAuthor();
        $ask    = sprintf('Author [%s]', $author);

        return (object) [
            'ask'     => $ask,
            'default' => $author
        ];
    }

    /**
     * Undocumented function
     *
     * @param string $vendor
     * @param string $author
     * @param string $desc
     * @return stdClass
     */
    public function confirm($vendor, $author, $desc) : stdClass
    {
        $this->setVendor($vendor)
             ->setAuthor($author)
             ->setDescription($desc);

        $preview = $this->getComposer();
        $ask     = 'Confirm? '. PHP_EOL . $preview;

        return (object) [
            'ask'     => $ask,
            'default' => false
        ];
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
     * Define o vendor padrão da aplicação
     *
     * @return Wizard
     */
    private function setComposer(Theme $theme) : Wizard
    {
        $this->composerInstance = new Composer($theme);

        return $this;
    }

    /**
     * Retorna o composer padrão da aplicação
     *
     * @return Composer
     */
    private function composer() : Composer
    {
        return $this->composerInstance;
    }


    /**
     * Retorna uma descrição padrão para o tema
     *
     * @return string
     */
    private function defaultDesc() : string
    {
        $project = $this->dir()->project();

        return sprintf("Theme for project '%s'", $project);
    }

    /**
     * Retorna um autor padrão para a criação
     * do tema
     *
     * @return string
     */
    private function defaultAuthor() : string
    {
        $author  = $this->config()->author();
        $name    = $author->name;
        $email   = $author->email;

        return sprintf("%s <%s>", $name, $email);
    }
}
