<?php

namespace Maestriam\Samurai\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Models\Foundation;
use Maestriam\Samurai\Foundation\DirectiveFinder;
use Maestriam\Samurai\Exceptions\ThemeExistsException;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

class Theme extends Foundation
{
    /**
     * Nome do tema para ser criado/manipulado
     *
     * @var string
     */
    public $name = '';

    /**
     * Caminho-base do tema
     *
     * @var string
     */
    public $path = '';

    /**
     * Apelido para ser chamado pelo Laravel Blade
     *
     * @var string
     */
    public $namespace = '';

    /**
     * Instância do classe que encontra todos as diretivas
     * de um tema
     *
     * @var DirectiveFinder
     */
    private $finder;

    /**
     * Undocumented function
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setPath($name);
        $this->setName($name);
        $this->setNamespace($name);
    }

    /**
     * Cria um novo diretório para construção de um tema
     * Retorna true em caso de sucesso na criação do tema
     *
     * @return Theme|null
     */
    public function build() : ?Theme
    {
        if ($this->exists()) {
            throw new ThemeExistsException($this->name);
        }

        $theme  = $this->path;
        $assets = $this->assetPath();
        $files  = $this->filePath();

        $this->file()->mkFolder($theme);
        $this->file()->mkFolder($assets);
        $this->file()->mkFolder($files);

        return (is_dir($theme)) ? $this : null;
    }

    /**
     * Tenta encontrar um tema questão
     * Caso não encontre, constua-o
     *
     * @return Theme
     */
    public function findOrBuild() : Theme
    {
        if (! $this->exists()) {
            return $this->build();
        }

        return $this->get();
    }

    /**
     * Retorna a instância de um tema
     * se caso o tema existir
     *
     * @return Theme|null
     */
    public function get() : ?Theme
    {
        if (! $this->exists()) {
            return null;
        }

        return $this;
    }

    /**
     * Retorna a instância de uma include para
     * um determinado tema
     *
     * @param string $name
     * @return Directive
     */
    public function include(string $name) : Directive
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        return $this->directivefy($name, 'include');
    }
    
    /**
     * Retorna a URL de assets do tema dentro 
     * do projeto Laravel
     *
     * @return string
     */
    public function public() : string
    {
        $url = 'themes/' . $this->name;

        return asset($url);
    }

    /**
     * Retorna o caminho público do projeto
     * onde os asses do projeto são armazenados
     *
     * @return string
     */
    public function publicPath() : string
    {
        return $this->dir()->public($this->name);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return Directive
     */
    public function component(string $name) : Directive
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        return $this->directivefy($name, 'component');
    }

    /**
     * Envia os assets para o diretório público do projeto
     *
     * @return boolean
     */
    public function publish() : bool
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        $from = $this->assetPath();
        $to   = $this->dir()->public($this->name);

        File::copyDirectory($from, $to);

        return (is_dir($to)) ? true : false;
    }

    /**
     * Define o tema como padrão para ser usado no projeto
     *
     * @return boolean
     */
    public function use() : bool
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        $steps[] = $this->file()->clearCache();
        $steps[] = $this->publish();
        $steps[] = $this->setCurrent();

        $this->load();

        return (in_array(false, $steps)) ? false : true;
    }

    /**
     * Retorna TODAS as diretivas cadastradas
     * dentro de um tema
     *
     * @return array
     */
    public function directives() : array
    {
        $files = $this->scan();

        if (empty($files)) return [];

        $collection = [];

        foreach($files as $path) {

            $request = $this->parseFilePath($path);

            if ($request == null) continue;

            $obj = $this->directivefy($request->name, $request->type);

            $collection[] = $obj;
        }

        return $collection;
    }

    /**
     * Carrega todas as diretivas de um tema para
     * ser usado dentro do projeto
     *
     * @return void
     */
    public function load()
    {
        $directives = $this->directives();

        if (empty($directives)) return true;

        foreach($directives as $directive) {
            $directive->load();
        }

        return true;
    }

    /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de diretivas (include/component)
     *
     * @return string
     */
    public function filePath() : string
    {
        return $this->dir()->files($this->name);
    }

    /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de assets (js/css/imgs)
     *
     * @return string
     */
    public function assetPath() : string
    {
        return $this->dir()->assets($this->name);
    }

    /**
     * Retorna se existe o diretório do tema
     * na base de temas
     *
     * @param string $name   Nome do tema
     * @return boolean
     */
    public function exists() : bool
    {
        $theme = $this->dir()->theme($this->name);

        return (is_dir($theme));
    }

    /**
     * Retorna se é nome específicado é válido para criação
     * de um tema
     *
     * @param string $name
     * @return boolean
     */
    public function isValidName(string $name) : bool
    {
        return $this->valid()->theme($name);
    }

    /* {Private Function} */

    /**
     * Identifica o nome e o tipo da diretiva através
     * de seu caminho absoluto
     *
     * @param string $file
     * @return object|null
     */
    private function parseFilePath(string $file) : ?object
    {
        $path = $this->filePath();

        return $this->parser()->file($path, $file);
    }

    /**
     * Varre todos os arquivos de um tema para encontrar suas
     * diretivas
     *
     * @return void
     */
    private function scan() : array
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        if ($this->finder == null) {
            $this->finder = new DirectiveFinder();
        }

        return $this->finder->scan($this->filePath());
    }

    /**
     * Define o nome do tema que será criado/manipulado
     *
     * @param string $name
     * @return $this
     */
    private function setName(string $name)
    {
        if (! $this->isValidName($name)) {
            throw new InvalidThemeNameException($name);
        }

        $this->name = strtolower($name);
        return $this;
    }

    /**
     * Define o "apelido" do tema para ser chamado no projeto
     *
     * @param string $name
     * @return void
     */
    private function setNamespace(string $name)
    {
        $this->namespace = $this->nominator()->namespace($name);
        return $this;
    }

    /**
     * Define o caminho-base do tema
     *
     * @param string $name
     * @return void
     */
    private function setPath(string $name)
    {
        $this->path = $this->dir()->theme($name);
        return $this;
    }

    /**
     * Retorna uma instância de uma diretiva de acordo
     * com os dados do nome, do tipo e do tema a qual pertence
     *
     * @param string $name  Nome da diretiva
     * @param string $type  Tipo que pertence
     * @return Directive
     */
    private function directivefy(string $name, string $type) : Directive
    {
        return new Directive($name, $type, $this);
    }

    /**
     * Registra o tema no arquivo de ambiente do projeto
     *
     * @return boolean
     */
    private function setCurrent() : bool
    {
        $key = $this->config()->env();

        $this->env()->set($key, $this->name);

        $current = $this->env()->get($key);

        return ($current == $this->name) ? true : false;
    }
}
