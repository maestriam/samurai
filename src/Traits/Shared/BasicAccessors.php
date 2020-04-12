<?php

namespace Maestriam\Samurai\Traits\Shared;

use stdClass;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Exceptions\InvalidAuthorException;

/**
 * 
 */
trait BasicAccessors
{    
    /**
     * Define o vendor que servirá para criação
     * do arquivo composer.json, como para o nome do tema
     *
     * @return Theme
     */
    public final function setVendor(string $vendor)
    {
        if (! $this->valid()->vendor($vendor)) {
            throw new InvalidThemeNameException($vendor);
        }

        $this->vendor = $vendor;
        return $this;
    }

    /**
     * Define o nome do autor do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return void
     */
    private final function setAuthor(string $author)
    {
        if (! $this->valid()->author($author)) {
            throw new InvalidAuthorException($author);
        }

        $this->author = $author;
        return $this;
    }

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return void
     */
    private final function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Retorna o vendor/tema sem tratamento
     * Usado no arquivo composer.json
     *
     * @return string
     */
    private final function getVendor() : string
    {
        return $this->vendor;
    }    
    
    /**
     * Retorna o nome e e-mail do autor definido para o tema.
     * Se não for encontrado um valor específico, retorna o valor
     * padrão definido no arquivo de configuração
     *
     * @return object
     */
    private final function getAuthor() : stdClass
    {
        if (! $this->author) {
            return $this->config()->author();
        }

        return $this->parser()->author($this->author);
    }

    /**
     * Retorna a descrição definido para o tema.
     * Se não for encontrado um autor específico, retorna o autor
     * padrão definido no arquivo de configuração
     *
     * @return object
     */
    private final function getDescription() : string
    {
        if (! $this->description) {
            return $this->config()->description();
        }

        return $this->description;
    }
}
