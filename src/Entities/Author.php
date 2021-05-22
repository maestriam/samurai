<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Exceptions\InvalidAuthorException;

class Author extends Foundation 
{
    private string $name; 

    private string $email;

    public function __construct(string $author = null)
    {
        if ($author) {
            $this->set($author);
        }
    }    
    
    /**
     * Retorna as informações padrões do autor, definido no config
     *
     * @return Author
     */
    public function default() : Author
    {
        $default = $this->config()->author();
        
        return $this->load($default);    
    }

    /**
     * Retorna/Define o nome do autor do tema.  
     * Se passar uma string como parâmetro, assume a função de definição.  
     * Informações utilizados dentro arquivo composer.json.  
     *
     * @param string $name
     * @return Author|string
     */
    public function name(string $name = null) : Author|string
    {
        if (! $name)  {
            return $this->getName();
        }  
        
        return $this->setName($name);
    }

    /**
     * Retorna/Define o e-mail do autor do tema.  
     * Se passar uma string como parâmetro, assume a função de definição.  
     * Informações utilizados dentro arquivo composer.json  
     *
     * @param string $email
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
     * Define o nome e o autor do tema, de acordo com o padrão:  
     * Ex: Giu Sampaio <<email@email.com>>
     * 
     * @param string $author
     * @return void
     * @throws InvalidAuthorException
     */
    public function set(string $author)
    {
        if (! $this->valid()->author($author)) {
            throw new InvalidAuthorException($author);
        }
        
        $author = $this->parser()->author($author);       

        return $this->load($author);
    }

    /**
     * Carrega o nome e o e-mail do autor de um objeto específico
     *
     * @param object $author
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
     * @param string $name
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
        return $this->name;
    }    
    
    /**
     * Define o email do autor do tema
     *
     * @param string $email
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
        return $this->email;
    }
}