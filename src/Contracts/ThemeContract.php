<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Author;
use Maestriam\Samurai\Entities\Structure;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Vendor;

interface ThemeContract
{
    /**
     * Define/Retorna o vendor do tema.  
     * Essas informações serão utilizadas para definir o nome e o distribuidor do tema.  
     * Se passar uma string como parâmetro, irá assumir que você quer definir o vendor.  
     *
     * @param string $vendor
     * @return Theme
     */
    public function vendor() : Vendor;

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return Theme
     */
    public function author(string $author = null) : Author|Theme;

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $description
     * @return Theme
     */
    public function description(string $description = null) : Theme|string;

    /**
     * Retorna o nome do tema
     *
     * @return string
     */
    public function name() : string;

    /**
     * Retorna o namespace do tema
     *
     * @return string
     */
    public function namespace() : string;

    /**
     * Retorna a instância de estrutura de diretórios do tema
     *
     * @return Structure
     */
    public function paths() : Structure;

    /**
     * Verifica se o tema já existe dentro do projeto
     *
     * @return boolean
     */
    public function exists() : bool;

    /**
     * Cria um novo tema dentro do projeto.
     * Caso o tema já exista, emite uma exception de erro 
     *
     * @return Theme
     * @throws ThemeExistsException
     */
    public function make() : Theme;
}