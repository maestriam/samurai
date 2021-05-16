<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Theme;

interface ThemeContract
{
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string|null  $key
     * @param  mixed  $default
     * @return mixed|\Illuminate\Config\Repository
     */

    /**
     * Define/Retorna o vendor do tema.  
     * Essas informações serão utilizadas para definir o nome e o distribuidor do tema.  
     * Se passar uma string como parâmetro, irá assumir que você quer definir o vendor.  
     *
     * @param string $vendor
     * @return Theme
     */
    public function vendor(string $vendor = null) : Theme|string;

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return Theme
     */
    public function author(string $author) : Theme;

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $description
     * @return Theme
     */
    public function description(string $description) : Theme;
}