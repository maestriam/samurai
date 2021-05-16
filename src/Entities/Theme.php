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
    use Validation,
        Composer,
        Construction,
        BasicAccessors,
        DirectiveHandling;

    /**
     * Nome do tema para ser criado/manipulado
     *
     * @var string
     */
    public $name = '';

    /**
     * Nome do distribuidor do tema/Nome do tema
     * Ex: vendor/theme
     *
     * @var string
     */
    public $vendor = '';

    /**
     * Caminho-base do tema
     *
     * @var string
     */
    public $path = '';

    /**
     * Apelido para ser chamado pelo Laravel Blade
     *
     * @var string
     */
    public $namespace = '';

    /**
     *
     *
     * @var string
     */
    public $author = null;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $description = null;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $distributor = null;

    /**
     * Instância do classe que encontra todos as diretivas
     * de um tema
     *
     * @var DirectiveFinder
     */
    private $finder;

    /**
     * Undocumented function
     *
     * @param string $name
     */
    public function __construct(string $vendor = null)
    {
        $this->vendor($vendor); //->parseVendor();
    }
    
    /**
     * {@inheritDoc}
     */
    public function vendor(string $vendor = null) : Theme|string
    {
        if ($vendor == null) {
            return $this->getVendor();
        }
        
        return $this->setVendor($vendor)->parseVendor();
    }

    /**
     * Define o nome do vendor do tema.  
     *
     * @return Theme
     */
    private function setVendor(string $vendor) : Theme
    {
        if (! $this->valid()->vendor($vendor)) {
            throw new InvalidThemeNameException($vendor);
        }

        $this->vendor = $vendor;
        return $this;
    }

    /**
     * Retorna o vendor do tema
     *
     * @return string
     */
    private function getVendor() : string
    {
        return $this->vendor;
    }

    /**
     * Interpreta as informações vindas do vendor e
     * define o nome, caminho, namespace e distribuidor do tema
     *
     * @return void
     */
    private function parseVendor(): Theme
    {
        if (! $this->vendor) {
            throw new InvalidThemeNameException($this->vendor);
        }

        $vendor = $this->parser()->vendor($this->vendor);

        $this->setName($vendor->name)
             ->setNamespace($vendor->name)             
             ->setDistributor($vendor->distributor)
             ->setPath($vendor->distributor, $vendor->name);

        return $this;
    }
    
    /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de diretivas (include/component)
     *
     * @return string
     */
    public function filePath() : string
    {
        $dist = $this->distributor;
        
        return $this->dir()->files($dist, $this->name);
    }

    /**
     * Define o nome do tema que será criado/manipulado
     *
     * @param string $name
     * @return $this
     */
    private function setName(string $name) : Theme
    {
        if (! $this->valid()->theme($name)) {
            throw new InvalidThemeNameException($name);
        }

        $this->name = strtolower($name);
        return $this;
    }

    /**
     * Define o nome do tema que será criado/manipulado
     *
     * @param string $name
     * @return Theme
     */
    private function setDistributor(string $dist) : Theme
    {
        if (! $this->isValidName($dist)) {
            throw new InvalidThemeNameException($dist);
        }

        $this->distributor = strtolower($dist);
        return $this;
    }

    /**
     * Define o namespace do tema para ser chamado no projeto
     *
     * @param string $name
     * @return Theme
     */
    private function setNamespace(string $name) : Theme
    {
        $this->namespace = $this->nominator()->namespace($name);
        return $this;
    }

    /**
     * Define o caminho-base do tema
     *
     * @param string $name
     * @return void
     */
    private function setPath(string $dist, string $name) : Theme
    {
        $this->path = $this->dir()->theme($dist, $name);
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function author(string $author) : Theme
    {
        if (! $this->valid()->author($author)) {
            throw new InvalidAuthorException($author);
        }

        $this->author = $author;        
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

    /**
     * Retorna uma instância de uma diretiva de acordo
     * com os dados do nome, do tipo e do tema a qual pertence
     *
     * @param string $name  Nome da diretiva
     * @param string $type  Tipo que pertence
     * @return Directive
     */
    private function directivefy(string $name, string $type) : Directive
    {
        return new Directive($name, $type, $this);
    }

    /**
     * Retorna se existe o diretório do tema
     * na base de temas
     *
     * @param string $name   Nome do tema
     * @return boolean
     */
    public function exists() : bool
    {
        $theme = $this->dir()->theme($this->distributor, $this->name);

        return (is_dir($theme)) ? true : false;
    }

    /**
     * Tenta encontrar um tema questão
     * Caso não encontre, constua-o
     *
     * @return Theme
     */
    public function findOrBuild() : Theme
    {
        if (! $this->exists()) {
            return $this->build();
        }

        return $this->get();
    }

    /**
     * Retorna a instância de um tema
     * se caso o tema existir
     *
     * @return Theme|null
     */
    public function get() : ?Theme
    {
        if (! $this->exists()) {
            return null;
        }

        return $this;
    }
}
