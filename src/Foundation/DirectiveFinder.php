<?php

namespace Maestriam\Samurai\Foundation;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Includer;

class DirectiveFinder
{
    private string $pattern = '.blade';

    private DirectiveParser $parserInstance;

    public function __construct(Theme $theme)
    {
        $this->init($theme);
    }

    /**
     * Recupera TODAS as diretivas de um tema.  
     *
     * @return array
     */
    public function all() : array
    {          
        $directives = [];

        $files = $this->readFiles();
        
        foreach($files as $file) {
            $directives[] = $this->parser()->parse($file)->toDirective();
        }

        return $directives;
    }

    /**
     * Retorna a instância de uma diretiva includer, de acordo com o tema e a sentença.  
     *
     * @param string $sentence
     * @return Includer
     */
    public function include(string $sentence) : Includer
    {
        return new Includer($this->theme(), $sentence);
    }

    /**
     * Retorna a instância de uma diretiva component, de acordo com o tema e a sentença.  
     *
     * @param string $sentence
     * @return Component
     */
    public function component(string $sentence) : Component
    {
        return new Component($this->theme(), $sentence);
    }

    /**
     * Retorna a instância do tema que será manipulado.  
     *
     * @return Theme
     */
    private function theme() : Theme
    {
        return $this->themeInstance;
    }

    /**
     * Inicia os atributos necessários para instanciar a classe.  
     *
     * @param Theme $theme
     * @return DirectiveFinder
     */
    private function init(Theme $theme) : DirectiveFinder
    {
        $this->themeInstance = $theme;
        $this->parserInstance = new DirectiveParser($theme);
     
        return $this;
    }    

    /**
     * Retorna a instância para identificação de uma diretiva,
     * através do caminho absoluto do arquivo da diretiva.  
     *
     * @return DirectiveParser
     */
    private function parser() : DirectiveParser
    {
        return $this->parserInstance;
    }

    /**
     * Retorna a lista, com o caminho completo, de todas as diretivas
     * inseridas no tema determinado.  
     *
     * @return array
     */
    private function readFiles() : array
    {        
        $path = $this->theme()->paths()->source();

        return FileSystem::folder($path)->files($this->pattern);
    }
}