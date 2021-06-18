<?php

namespace Maestriam\Samurai\Foundation;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Includer;

class DirectiveFinder
{
    private string $pattern = '.blade';

    public function __construct(Theme $theme)
    {
        $this->setTheme($theme);
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

            $file = $this->parseFile($file);

            $directives[] = $this->identify($file);
        }

        return $directives;
    }

    /**
     * Recebe o caminho da diretiva e retorna somente a sentença para
     * do diretiva
     *
     * @param string $file
     * @return string
     */
    private function parseFile(string $file) : string
    {
        $path = $this->source();

        $file = str_replace($path .'/', '', $file);
        $file = str_replace('.blade', '', $file);

        return $file;
    }

    /**
     * Identifica o tipo de diretiva e retorna uma instância do tipo
     * Includer ou Component.  
     *
     * @param string $file
     * @return Component|Includer
     */
    private function identify(string $file) : Component|Includer
    {
        list($sentence, $type) = explode('.', $file);

        if ($type == 'component') {
            return $this->component($sentence);
        }
        
        return $this->include($sentence);
    }

    /**
     * Define o tema para apanhar as diretivas inseridass
     *
     * @param Theme $theme
     * @return DirectiveFinder
     */
    private function setTheme(Theme $theme) : DirectiveFinder
    {
        $this->themeInstance = $theme;
     
        return $this;
    }

    /**
     * Retorna a lista, com o caminho completo, de todas as diretivas
     * inseridas no tema determinado.  
     *
     * @return array
     */
    private function readFiles() : array
    {        
        $path = $this->source();

        return FileSystem::folder($path)->files($this->pattern);
    }     

    /**
     * Retorna a instância de uma diretiva component para o tema.  
     *
     * @param string $sentence
     * @return Includer
     */
    public function component(string $sentence) : Component
    {
        return new Component($this->theme(), $sentence);
    }

    public function include(string $sentence) : Includer
    {
        return new Includer($this->theme(), $sentence);
    }

    private function source() : string
    {
        return $this->theme()->paths()->source();
    }

    private function theme() : Theme
    {
        return $this->themeInstance;
    }   

    private function parser() : FilenameParser
    {
        return new FilenameParser();
    }
}