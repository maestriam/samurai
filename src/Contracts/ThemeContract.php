<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Author;
use Maestriam\Samurai\Entities\Includer;
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
     * @return Author|Theme
     */
    public function author(string $author = null) : Author|Theme;

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
     * Retorna o nome-do-distribuidor/nome-do-tema.    
     * Padrão de nome do pacote utilizado no composer.  
     *
     * @return string
     */
    public function package() : string;

    /**
     * Verifica se o tema já existe dentro do projeto
     *
     * @return boolean
     */
    public function exists() : bool;

    /**
     * Retorna a prévia de como irá ficar o arquivo composer.json.   
     * Utilizado junto com o Wizard, auxiliar para criação de temas de modo
     * interativo via console    
     *
     * @return string
     */
    public function preview() : string;

    /**
     * Retorna um tema existente
     *
     * @return Theme|null
     */
    public function find() : ?Theme;

    /**
     * Define a descrição do tema.  
     * Usado no arquivo composer.json
     *
     * @param string $description
     * @return Theme|string
     */
    public function description(string $description = null) : Theme|string;

    /**
     * Cria um novo tema dentro do projeto.
     * Caso o tema já exista, emite uma exception de erro 
     *
     * @return Theme
     * @throws ThemeExistsException
     */
    public function make() : Theme;
    
    /**
     * Verifica se o tema existe dentro do projeto.  
     * Se não existir, cria o tema.
     *
     * @return Theme
     */
    public function findOrCreate() : Theme;

    /**
     * Registra o tema como atual no projeto.  
     *
     * @return void
     */
    public function use() : void;

    /**
     * Retorna a instância de uma diretiva include para o tema.  
     *
     * @param string $sentence
     * @return Includer
     */
    public function include(string $sentence) : Includer;
}
