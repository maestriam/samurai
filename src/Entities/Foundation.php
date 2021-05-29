<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Foundation\ConfigKeeper;
use Maestriam\Samurai\Foundation\EnvHandler;
use Maestriam\Samurai\Foundation\FileSystem;
use Maestriam\Samurai\Foundation\FileNominator;
use Maestriam\Samurai\Foundation\FilenameParser;
use Maestriam\Samurai\Foundation\SyntaxValidator;
use Maestriam\Samurai\Foundation\DirectoryStructure;

class Foundation
{
    /**
     * Classe auxiliar para gerenciamento de estrutura de diretórios
     * dentor do projeto
     *
     * @var DirectoryStructure
     */
    private $dir;

    /**
     * Classe auxiliar para criação de arquivos/diretórios
     * dentro do projeto
     *
     * @var FileSystem
     */
    private $file;

    /**
     * Classe auxiliar para validação de nome de diretivas/temas
     * e verificações de tipos
     *
     * @var SyntaxValidator
     */
    private $valid;

    /**
     * Classe auxiliar para nomeação de diretivas/namespaces
     * de acordo com as regras negócios do Blade
     *
     * @var FileNominator
     */
    private $nominator;

    /**
     * Instância do helper para atualizar arquivos .env
     *
     * @var EnvHandler
     */
    private $env;

    /**
     * Instância do helper para
     *
     * @var ConfigKeeper
     */
    private $config;
    
    /**
     * Instância do parser de filepath para objeto
     *
     * @var FilenameParser
     */
    private $parser;

    /**
     * Retorna uma instância auxiliar para 
     * tarefas de sistema de arquivos
     *
     * @return void
     */
    protected function file() : FileSystem
    {
        if ($this->file == null) {
            $this->file = new FileSystem();
        }

        return $this->file;
    }

    /**
     * Classe auxiliar para validar a sintaxe das informações preenchidas 
     * sobre o tema
     *
     * @return SyntaxValidator
     */
    protected function valid() : SyntaxValidator
    {
        if ($this->valid == null) {
            $this->valid = new SyntaxValidator();
        }

        return $this->valid;
    }

    /**
     * Classe auxiliar para  instância de RN sobre 
     * estrutura de pasta do tema
     *
     * @return DirectoryStructure
     */
    protected function dir() : DirectoryStructure
    {
        if ($this->dir == null) {
            $this->dir = new DirectoryStructure();
        }

        return $this->dir;
    }

    /**
     * Classe auxiliar para retorno das informações de configurações do pacote
     *
     * @return void
     */
    protected function config() : ConfigKeeper
    {
        if (! $this->config) {
            $this->config = new ConfigKeeper();
        }

        return $this->config;
    }

    /**
     * Classe auxiliar para identificar o nome e o tipo da diretiva, 
     * através de seu caminho absoluto
     *
     * @param string $file
     * @return object|null
     */
    protected function parser() : FilenameParser
    {
        if ($this->parser == null) {
            $this->parser = new FilenameParser();
        }

        return $this->parser;
    }

    protected function env() : EnvHandler
    {
        if (! $this->env) {
            $this->env = new EnvHandler();
        }

        return $this->env;
    }

    protected function nominator() : FileNominator
    {
        if ($this->nominator == null) {
            $this->nominator = new FileNominator();
        }

        return $this->nominator;
    }
}
