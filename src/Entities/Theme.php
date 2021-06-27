<?php

namespace Maestriam\Samurai\Entities;

use Illuminate\Support\Facades\File;
use Maestriam\Samurai\Entities\Foundation;
use Maestriam\Samurai\Foundation\DirectiveFinder;
use Maestriam\Samurai\Exceptions\ThemeExistsException;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Contracts\Entities\ThemeContract;

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
     * Regras de negócio sobre busca de diretivas dentro do tema.  
     *
     * @var DirectiveFinder
     */
    protected DirectiveFinder $finderInstance;

    /**
     * Regras de negócio do tema
     *
     * @param string $package
     */
    public function __construct(string $package)
    {
        $this->init($package);
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
    public function package() : string
    {
        return $this->vendor()->package();
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
     * {@inheritDoc}
     */
    public function find() : ?Theme
    {
        if (! $this->exists()) {
            return null;
        }

        return $this->import();
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
    public function make() : Theme
    {
        if ($this->exists()) {
            throw new ThemeExistsException($this->package());
        }

        $this->structure()->init();
        
        $this->composer()->create()->load();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function findOrCreate() : Theme
    {
        if (! $this->exists()) {
            return $this->make();
        }

        return $this->import();
    }

    /**
     * {@inheritDoc}
     */
    public function use() : Theme
    {
        $this->guard();

        $this->register();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function include(string $sentence) : Includer
    {
        return $this->finder()->include($sentence);
    }

    /**
     * {@inheritDoc}
     */
    public function component(string $sentence) : Component
    {
        return $this->finder()->component($sentence);
    }

    /**
     * {@inheritDoc}
     */
    public function directives() : array
    {        
        return $this->finder()->all();
    }

    /**
     * {@inheritDoc}
     */
    public function load() : Theme
    {
        foreach ($this->directives() as $directive) {    
            $directive->load();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function publish() : bool
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->package());
        }

        $from = $this->structure()->assets();
        $to   = $this->structure()->public();

        File::copyDirectory($from, $to);

        return (is_dir($to)) ? true : false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function url(string $file = null) : string
    {
        $domain  = $this->env()->get('APP_URL');
        $public  = $this->config()->publishable();
        $package = $this->package();

        $file =  '/' . $file ?? '';
        $file = str_replace("'", "", $file);

        return sprintf('%s/%s/%s%s', $domain, $public, $package, $file);
    }

    /**
     * Registra o nome do pacote do tema no arquivo de ambiente 
     * do projeto Laravel
     *
     * @return void
     */
    private function register()
    {
        $name = $this->package();

        $key = $this->config()->env();

        $this->env()->set($key, $name);
    }

    /**
     * Inicia as regras de negócio do tema  
     * Se o tema já existir dentro do projeto, carrega suas informações  
     *
     * @param string $package
     * @return Theme
     */
    private function init(string $package) : Theme
    {
        $this->setVendor($package)
             ->setDirectiveFinder()
             ->setComposer()
             ->setStructure();

        if ($this->exists()) {
            return $this->import();
        }        

        return $this;
    }

    /**
     * Carrega as informações vindas do arquivo composer.json
     * para dentro da instância  
     *
     * @return Theme
     */
    private function import() : Theme
    {
        $info = $this->composer()->load()->info();

        $this->author()->name($info->authors[0]->name);
        $this->author()->email($info->authors[0]->email);

        return $this;
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

    /**
     * Define a instância de busca de diretivas dentro do tema.  
     *
     * @return Theme
     */
    private function setDirectiveFinder() : Theme
    {
        $this->finderInstance = new DirectiveFinder($this);

        return $this;
    }

    /**
     * Retorna a instância de busca de diretivas dentro do tema.  
     *
     * @return DirectiveFinder
     */
    private function finder() : DirectiveFinder
    {
        return $this->finderInstance;
    }

    /**
     * Faz as devidas validações sobre o tema.  
     * Se existir algo incompátivel, emite um Exception.  
     *
     * @return void
     */
    private function guard() : void
    {
        if ($this->exists()) {
            return; 
        }

        throw new ThemeNotFoundException($this->package());
    }

}