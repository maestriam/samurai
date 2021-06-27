<?php

namespace Maestriam\Samurai\Contracts\Entities;

use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Includer;

interface DirectiveContract
{
    /**
     * Retorna a sentença definida pelo usuário para manipulação 
     * de uma diretiva
     *
     * @return string
     */
    public function sentence() : string;
    
    /**
     * Retorna o tipo de diretiva 
     * 
     * @return string
     */
    public function type() : string;

    /**
     * Retorna o caminho absoluto da diretiva 
     * 
     * @return string
     */
    public function path() : string;

    /**
     * Retorna o alias para a chamada dentro do projeto,
     * como camel-case e como kebab-case.  
     * 
     * @return string
     */
    public function alias() : object;

    /**
     * Retorna o nome do arquivo
     *
     * @return string
     */
    public function filename() : string;

    /**
     * Retorna as informações para renderizar no template
     *
     * @return array
     */
    public function placeholders() : array;

    /**
     * Executa a criação de uma nova diretiva dentro do projeto,
     * dependendo do tipo da diretiva instanciada
     *
     * @return Component|Includer
     */
    public function create() : Component|Includer;

    /**
     * Carrega a diretiva para ser utilizada dentro da aplicação Laravel,
     * dentro dos arquivos Blade
     *
     * @return Component|Includer
     */
    public function load() : Component|Includer;
}