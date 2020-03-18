<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Foundation\ConfigKeeper;
use Maestriam\Samurai\Foundation\EnvHandler;
use Maestriam\Samurai\Foundation\FileSystem;
use Maestriam\Samurai\Foundation\FileNominator;
use Maestriam\Samurai\Foundation\SyntaxValidator;
use Maestriam\Samurai\Foundation\StructureDirectory;
use Maestriam\Samurai\Foundation\FilenameParser;

class Foundation
{
    /**
     *
     *
     * @var StructureDirectory
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
     * Retorna uma instância de um auxiliar para 
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
     * Undocumented function
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
     * Undocumented function
     *
     * @return FileNominator
     */
    protected function nominator() : FileNominator
    {
        if ($this->nominator == null) {
            $this->nominator = new FileNominator();
        }

        return $this->nominator;
    }

    /**
     * Retorna uma instância de RN sobre 
     * estrutura de pasta do tema
     *
     * @return StructureDirectory
     */
    protected function dir() : StructureDirectory
    {
        if ($this->dir == null) {
            $this->dir = new StructureDirectory();
        }

        return $this->dir;
    }

    /**
     * Undocumented function
     *
     * @return EnvHandler
     */
    protected function env() : EnvHandler
    {
        if (! $this->env) {
            $this->env = new EnvHandler();
        }

        return $this->env;
    }

    /**
     * Retorna a instância de configurações do Samurai
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
     * Identifica o nome e o tipo da diretiva através
     * de seu caminho absoluto
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

}
