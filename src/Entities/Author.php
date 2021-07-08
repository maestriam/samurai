<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Exceptions\InvalidAuthorException;

class Author extends Foundation
{
    /**
     * Nome do autor do tema
     * 
     * @var string
     */
    private string $_name; 
    
    /**
     * E-mail do autor do tema
     * 
     * @var string
     */
    private string $email;

    /**
     * Instância com as regras de negócios sobre o autor do tema.  
     * Na ausência de informações sobre o autor, irá pegar as informações
     * definida nas configurações do projeto como padrão.  
     *
     * @param string $author
     */
    public function __construct(string $author = null)
    {
        ($author) ? $this->set($author) : $this->default();
    }    

    /**
     * Retorna/Define o nome do autor do tema.  
     * Se passar uma string como parâmetro, assume a função de definição.  
     * Informações utilizados dentro arquivo composer.json.  
     *
     * @param  string $name
     * @return Author|string
     */
    public function name(string $name = null) : Author|string
    {
        if (! $name) {
            return $this->getName();
        }  
        
        return $this->setName($name);
    }

    /**
     * Retorna/Define o e-mail do autor do tema.  
     * Se passar uma string como parâmetro, assume a função de definição.  
     * Informações utilizados dentro arquivo composer.json  
     *
     * @param  string $email
     * @return Author|string
     */
    public function email(string $email = null) : Author|string
    {
        if (! $email) {
            return $this->getEmail();
        } 
        
        return $this->setEmail($email);
    }

    /**
     * Retorna a assinatura do autor.   
     * Ex: Joe Doe <foo@acme.com>
     *
     * @return string
     */
    public function signature() : string
    {
        return sprintf("%s <%s>", $this->name(), $this->email());
    }

    /**
     * Define o nome e o autor do tema, de acordo com o padrão:  
     * Ex: Giu Sampaio <<email@email.com>>
     * 
     * @param  string $author
     * @return Author
     * @throws InvalidAuthorException
     */
    public function set(string $author) : Author
    {
        if (! $this->valid()->author($author)) {
            throw new InvalidAuthorException($author);
        }
        
        $author = $this->parser()->author($author);       

        return $this->load($author);
    }

    /**
     * Carrega o nome, distribuidora e o e-mail do autor de um objeto específico
     *
     * @param  object $author
     * @return Author
     */
    private function load(object $author) : Author
    {
        return $this->name($author->name)->email($author->email);
    }    

    /**
     * Define o nome do autor do tema
     * Usado no arquivo composer.json
     *
     * @param  string $name
     * @return Author
     */
    private function setName(string $name) : Author
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Retorna o nome do autor do tema
     *
     * @return string
     */
    private function getName() : string
    {
        return $this->name ?? $this->config()->author()->name;
    }    
    
    /**
     * Define o email do autor do tema
     *
     * @param  string $email
     * @return Author
     */
    private function setEmail(string $email) : Author
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Retorna o e-mail do autor do tema
     *
     * @return string
     */
    private function getEmail() : string
    {
        return $this->email ?? $this->config()->author()->email;
    }

    /**
     * Retorna as informações padrões do autor, definido no config
     *
     * @return Author
     */
    private function default() : Author
    {
        $default = $this->config()->author();
        
        return $this->load($default);    
    }
}
