<?php

namespace Maestriam\Samurai\Entities\Theme;

use Maestriam\Samurai\Foundation\DirectoryStructure;

/**
 * Classe auxiliar responsável para gerenciar os caminhos e diretório
 * importantes dentro do tema
 */
class ThemeStructure
{
    private DirectoryStructure $directoryStructure;
    
    public function __construct()
    {
        
    }

    /**
     * Retorna uma instância de RN sobre 
     * estrutura de pasta do tema
     *
     * @return DirectoryStructure
     */
    protected function dir() : DirectoryStructure
    {
        if ($this->directoryStructure == null) {
            $this->directoryStructure = new DirectoryStructure();
        }

        return $this->directoryStructure;
    }

    /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de diretivas (include/component)
     *
     * @return string
     */
    public function files() : string
    {
        $dist = $this->distributor;
        
        return $this->dir()->files($dist, $this->name);
    }    
}