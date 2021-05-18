<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

class Vendor extends Foundation
{
    /**
     * Nome do projeto 
     */
    private string $name;

    /**
     * Distribuidor do projeto
     */
    private string $distributor;

    /**
     * Nome do distribuidor/Nome do projeto
     */
    private string $package;

    /**
     * 
     *
     * @param string $vendor
     */
    public function __construct(string $package)
    {
        $this->setPackage($package)->parsePackage();
    }
    
    /**
     * Retorna o nome do distribuidor do pacote
     *
     * @return string
     */
    public function distributor() : string
    {
        return $this->distributor;
    }

    /**
     * Retorna o nome do projeto
     *
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * Retorna o nome do distribuidor/nome do projeto
     *
     * @return string
     */
    public function package() : string
    {
        return $this->package;
    }

    /**
     * Retorna o namespace baseado no nome do distribuidor e do projeto
     *
     * @return string
     */
    public function namespace() : string
    {
        return ucfirst($this->distributor) ."/". ucfirst($this->name);
    }

    /**
     * Define o nome do pacote do projeto
     *
     * @param string $package
     * @return Vendor
     */
    private function setPackage(string $package) : Vendor
    {
        if (! $this->valid()->vendor($package)) {
            throw new InvalidThemeNameException($package);
        }

        $this->package = $package;
        return $this;
    }

    /**
     * Interpreta as informações vindas do vendor para definir
     * o nome, caminho, namespace e distribuidor do tema
     *
     * @return Vendor
     */
    private function parsePackage(): Vendor
    {
        if (! $this->package) {
            throw new InvalidThemeNameException($this->package);
        }

        $package = $this->parser()->vendor($this->package);

        $name = $package->name;
        $dist = $package->distributor;

        $this->setName($name)->setDist($dist);

        return $this;
    }

    /**
     * Define o nome do projeto
     *
     * @param string $name
     * @return Vendor
     */
    private function setName(string $name) : Vendor
    {
        if (! $this->valid()->theme($name)) {
            throw new InvalidThemeNameException($name);
        }

        $this->name = strtolower($name);
        return $this;
    }

    /**
     * Define o nome da distribuição do projeto
     *
     * @param string $dist
     * @return Vendor
     */
    private function setDist(string $dist) : Vendor
    {
        if (! $this->valid()->theme($dist)) {
            throw new InvalidThemeNameException($dist);
        }

        $this->distributor = strtolower($dist);
        return $this;
    }
}