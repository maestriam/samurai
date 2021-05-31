<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Contracts\ThemeContract;
use Maestriam\Samurai\Entities\Foundation;
use Maestriam\Samurai\Exceptions\ThemeExistsException;

;
use Maestriam\Samurai\Foundation\DirectiveFinder;

class Theme extends Foundation implements ThemeContract
{
    /**
     * Nome do distribuidor do tema/nome do tema
     * Ex: vendor/theme
     *
     * @var Vendor
     */
    protected Vendor $vendorInstance;

    /**
     * Informações do autor do tema
     *
     * @var Author
     */
    protected Author $authorInstance;

    /**
     * Controle de caminhos de tema
     * 
     * @var Structure
     */    
    protected Structure $structureInstance;

    /**
     * Controle do arquivo composer.json do tema
     * 
     * @var Composer
     */
    protected Composer $composerInstance;

    /**
     * Instância do classe que encontra todos as diretivas
     * de um tema
     *
     * @var DirectiveFinder
     */
    protected DirectiveFinder $finderInstance;

    /**
     * Regras de negócio do tema
     *
     * @param string $name
     */
    public function __construct(string $vendor)
    {
        $this->setVendor($vendor)->setStructure()->setComposer();        
    }
    
    /**
     * {@inheritDoc}
     */
    public function vendor() : Vendor
    {
        return $this->vendorInstance;
    }

    /**
     * {@inheritDoc}
     */
    public function author(string $author = null) : Author|Theme
    {
        if (! $author) {
            return $this->getAuthor();
        }

        return $this->setAuthor($author);
    }

    /**
     * {@inheritDoc}
     */
    public function name() : string
    {
        return $this->vendor()->name();
    }

    /**
     * {@inheritDoc}
     */
    public function namespace() : string
    {
        return $this->vendor()->namespace();
    }

    /**
     * {@inheritDoc}
     */
    public function paths() : Structure
    {
        return $this->structureInstance;
    }

    /**
     * {@inheritDoc}
     */
    public function make() : Theme
    {
        if ($this->exists()) {
            throw new ThemeExistsException($this->vendor()->package());
        }

        $this->structure()->init();
        $this->composer()->create();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function description(string $description = null) : Theme|string
    {
        if (! $description) {
            return $this->composer()->description();
        }
        
        $this->composer()->description($description);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function exists() : bool
    {
        return $this->composer()->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function preview() : string 
    {
        return $this->composer()->preview();
    }

    /**
     * Define o nome do vendor do tema.  
     *
     * @return Theme
     */
    private function setVendor(string $vendor) : Theme
    {
        $this->vendorInstance = new Vendor($vendor);

        return $this;
    }

    /**
     * Define as informações do autor do tema
     *
     * @param string $author
     * @return Theme
     */
    private function setAuthor(string $author) : Theme
    {
        $this->authorInstance = new Author($author);
        
        return $this;
    }

    /**
     * Retorna as informações do autor do tema
     *
     * @return Author
     */
    private function getAuthor() : Author
    {
        return $this->authorInstance ?? new Author();
    }

    /**
     * Define a instância de estrutura de diretórios do tema
     *
     * @return Theme
     */
    private function setStructure() : Theme
    {
        $vendor = $this->vendor();

        $this->structureInstance = new Structure($vendor);

        return $this;
    }

    /**
     * Retorna a instância de estrutura do tema
     *
     * @return Structure
     */
    private function structure() : Structure
    {
        return $this->structureInstance;
    }

    /**
     * Define o composer do tema
     *
     * @return Theme
     */
    private function setComposer() : Theme
    {
        $this->composerInstance = new Composer($this);

        return $this;
    }

    /**
     * Retorna a instância do composer do tema
     *
     * @return Theme
     */
    private function composer() : Composer
    {
        return $this->composerInstance;
    }
}