<?php

namespace Maestriam\Samurai\Entities;

class Structure extends Foundation 
{
    /**
     * Nome do distribuido do tema
     */
    private string $dist;

    /**
     * Nome do tema
     */
    private string $theme;

    /**
     * Gerencia os caminhos do tema
     *
     * @param Vendor $vendor
     */
    public function __construct(Vendor $vendor)
    {
        $this->loadVendor($vendor);
    }

    /**
     * Retorna o caminho público do projeto
     * onde os asses do projeto são armazenados
     *
     * @return string
     */
    public function public() : string 
    {        
        return $this->dir()->public($this->dist, $this->theme);        
    }

     /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de assets (js/css/imgs)
     *
     * @return string
     */
    public function assets() : string 
    {        
        return $this->dir()->assets($this->dist, $this->theme);
    }

    /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de diretivas (include/component)
     *
     * @return string
     */
    public function files() : string
    {        
        return $this->dir()->files($this->dist, $this->theme);
    }
    
    /**
     * Carrega as informações do vendor para gerar os caminhos 
     * do tema específicado
     *
     * @param Vendor $vendor
     * @return Structure
     */
    private function loadVendor(Vendor $vendor) : Structure
    {
        $this->dist = $vendor->distributor();

        $this->theme = $vendor->name();

        return $this;
    }
}