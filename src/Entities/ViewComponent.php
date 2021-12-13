<?php

namespace Maestriam\Samurai\Entities;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Concerns\WithFileNominator;

class ViewComponent extends Component
{
    use WithFileNominator;

    /**
     * Caminho do arquivo blade 
     *
     * @var string
     */
    protected ?string $view = null;

    /**
     * Tema atual do projeto. 
     *
     * @var Theme
     */
    private Theme $theme;

    public function __construct()
    {
        $this->init();
    }

    /**
     * Carrega as informações do tema atual e tenta
     * encontrar o arquivo blade a este ViewComponent.
     *
     * @return void
     */
    protected function init() : ViewComponent
    {
        return $this->setTheme()->initView();
    }

    /**
     * Define as informações do tema atual no projeto.
     *
     * @return  ViewComponent
     */
    private function setTheme() : ViewComponent
    {
        $this->theme = Samurai::base()->current();

        return $this;
    }

    /**
     * Tenta encontrar o componente Blade com o mesmo nome da classe
     * no tema atual. Se encontrar, vincula o ViewComponent ao 
     * componente.  
     *
     * @return  ViewComponent
     */
    protected function initView() : ViewComponent
    {        
        $class = $this->getName(); 

        $directive = $this->getDirective($class);

        if (! $directive) {
            return $this;
        }
        
        $path = $directive->relative();
        
        return $this->setView($path);
    }
    
    /**
     * Define o caminho do arquivo que será carregado pelo ViewComponent
     *
     * @param string $path  
     *
     * @return ViewComponent
     */
    protected function setView(string $path) : ViewComponent
    {
        $theme = $this->theme->namespace();

        $this->view = $this->getBladeFile($theme, $path);

        return $this;
    }
    
    /**
     * Faz uma varredura em todas as diretivas do tema atual e tenta
     * encontrar uma diretiva com o mesmo nome do ViewComponent.  
     * Se não encontrar, deve retornar nulo.  
     *
     * @param string 
     *
     * @return Directive 
     */
    protected function getDirective(string $name) : ?Directive
    {
        $components = $this->theme->directives();

        foreach ($components as $component) {

            if ($component->name() == $name) {
                return $component;
            }
        }  
        
        return null;
    }
    
    /**
     * Retorna o nome da classe do ViewComponent
     *
     * @return  string 
     */
    protected function getName() : string
    {
        $name = class_basename($this);
        
        $class = Str::kebab($name);       

        return $class;
    }

    protected function getBladeFile($theme, $path) : string
    {
        return $this->nominator()->blade($theme, $path);
    }

    /**
     * Retorna o nome do arquivo
     *
     * @return string  
     */
    public function getView() : string
    {
        return $this->view;
    }

    /**
     * Renderiza o arquivo Blade no front.
     *
     * @return 
     */
    public function render() 
    {
        return view($this->view);
    }
}