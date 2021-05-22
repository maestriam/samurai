<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Contracts\ComposerContract;

class Composer implements ComposerContract
{
    private string $desc;

    public function __construct(Vendor $vendor, string $desc = null)
    {
        $this->setVendor($vendor);

        if ($desc) {
            $this->description($desc);
        }
    }

    /**
     * Retorna/Define a descrição do tema 
     * Se passar uma string como parâmetro, assume a função de definição
     *
     * @param string $desc
     * @return string|Composer
     */
    public function description(string $desc = null) : string|Composer
    {
        if (! $desc) {
            return $this->getDescription();
        }

        return $this->setDescription($desc);
    }

    /**
     * Define o vendor do tema
     *
     * @param Vendor $vendor
     * @return Composer
     */
    private function setVendor(Vendor $vendor) : Composer
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Define a descrição do tema
     *
     * @param string $desc
     * @return Composer
     */
    private function setDescription(string $desc) : Composer
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Retorna a descrição do tema
     *
     * @return string
     */
    private function getDescription() : string
    {
        return $this->desc;
    }
}