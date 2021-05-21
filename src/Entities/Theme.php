<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Contracts\ThemeContract;
use Maestriam\Samurai\Entities\Foundation;
use Maestriam\Samurai\Exceptions\InvalidAuthorException;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Traits\Shared\Composer;
use Maestriam\Samurai\Traits\Theme\Validation;
use Maestriam\Samurai\Traits\Theme\Construction;
use Maestriam\Samurai\Foundation\DirectiveFinder;
use Maestriam\Samurai\Traits\Theme\DirectiveHandling;
use Maestriam\Samurai\Traits\Shared\BasicAccessors;

class Theme extends Foundation 
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
     * Instância do classe que encontra todos as diretivas
     * de um tema
     *
     * @var DirectiveFinder
     */
    protected DirectiveFinder $finderInstance;

    /**
     * Descrição do tema
     *
     * @var string
     */
    protected $description = null;

    /**
     * Regras de negócio do tema
     *
     * @param string $name
     */
    public function __construct(string $vendor = null)
    {
        if ($vendor) {
            $this->vendor($vendor)->setStructure();
        }   
    }
    
    /**
     * {@inheritDoc}
     */
    public function vendor(string $vendor = null) : Theme|Vendor
    {
        if ($vendor == null) {
            return $this->getVendor();
        }
        
        return $this->setVendor($vendor);
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
     * Retorna as informações sobre o vendor do tema
     *
     * @return Vendor
     */
    private function getVendor() : Vendor
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
     * Retorna as informações do autor do tema
     *
     * @return Author
     */
    private function getAuthor() : Author
    {
        return $this->authorInstance;
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
     * Retorna o nome do projeto
     *
     * @return string
     */
    public function name() : string
    {
        return $this->vendor()->name();
    }

    /**
     * Retorna o namespace do tema
     *
     * @return string
     */
    public function namespace() : string
    {
        return $this->vendor()->namespace();
    }

    /**
     * Retorna a instância de estrutura de diretórios do tema
     *
     * @return Structure
     */
    public function paths() : Structure
    {
        return $this->structureInstance;
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
     * {@inheritDoc}
     */
    public function description(string $description) : Theme
    {
        $this->description = $description;

        return $this;
    }
}














// /**
//      * Retorna uma instância de uma diretiva de acordo
//      * com os dados do nome, do tipo e do tema a qual pertence
//      *
//      * @param string $name  Nome da diretiva
//      * @param string $type  Tipo que pertence
//      * @return Directive
//      */
//     private function directivefy(string $name, string $type) : Directive
//     {
//         return new Directive($name, $type, $this);
//     }

//     /**
//      * Retorna se existe o diretório do tema
//      * na base de temas
//      *
//      * @param string $name   Nome do tema
//      * @return boolean
//      */
//     public function exists() : bool
//     {
//         $theme = $this->dir()->theme($this->distributor, $this->name);

//         return (is_dir($theme)) ? true : false;
//     }

//     /**
//      * Tenta encontrar um tema questão
//      * Caso não encontre, constua-o
//      *
//      * @return Theme
//      */
//     public function findOrBuild() : Theme
//     {
//         if (! $this->exists()) {
//             return $this->build();
//         }

//         return $this->get();
//     }

//     /**
//      * Retorna a instância de um tema
//      * se caso o tema existir
//      *
//      * @return Theme|null
//      */
//     public function get() : ?Theme
//     {
//         if (! $this->exists()) {
//             return null;
//         }

//         return $this;
//     }    