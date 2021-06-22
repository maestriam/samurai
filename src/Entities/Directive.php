<?php

namespace Maestriam\Samurai\Entities;

use Illuminate\Support\Str;
use Maestriam\Samurai\Entities\Theme;
use Illuminate\Support\Facades\Blade;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Contracts\Entities\DirectiveContract;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
use Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException;

abstract class Directive extends Source implements DirectiveContract
{
    /**
     * Nome da diretiva
     *
     * @var string
     */
    protected string $name;

    /**
     * Sentença que foi inserida pelo usuário,
     * que irá fornecer o nome/sub-diretório
     *
     * @var string
     */
    protected string $sentence;

    /**
     * Tipo da diretiva
     *
     * @var string
     */
    protected string $type;

    /**
     * Tema de origem
     *
     * @var Theme
     */
    protected $theme;

    /**
     * Caminho do arquivo
     *
     * @var string
     */
    protected string $path;

   /**
    * Apelido pelo qual é chamado dentro do projeto
    *
    * @var string
    */
    protected string $alias;

    /**
     * Instância as regras de negócio de uma diretiva
     *
     * @param Theme $theme
     * @param string $sentence
     */
    public function __construct(Theme $theme, string $sentence)
    {
        $this->init($theme, $sentence, $this->type());
    }

    /**
     * {@inheritDoc}
     */
    public function sentence() : string
    {
        return $this->sentence;
    }

    /**
     * {@inheritDoc}
     */
    public function type() : string
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function path() : string
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    public function alias() : string
    {
        return $this->alias;
    }

    /**
     * {@inheritDoc}
     */
    public function filename() : string
    {        
        return $this->nominator()->filename($this->sentence(), $this->type());
    }

    /**
     * {@inheritDoc}
     */
    public function placeholders() : array
    {
        return ['name' => $this->name];
    }

    /**
     * Retorna o nome da diretiva.  
     *
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function create() : Component|Includer
    {
        $info = $this->createFile();

        $this->setPath($info->absolute_path);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function load() : Component|Includer
    {                      
        $path = $this->relative();
        
        $namespace = $this->theme()->namespace();

        $file = $this->nominator()->blade($namespace, $path);
        
        Blade::component($file, $this->alias());

        return $this;
    }
    
    /**
     * Retorna o caminho relativo da diretiva dentro do tema
     *
     * @return string
     */
    public function relative() : string
    {
        $path = $this->path();

        $base = $this->theme()->paths()->root() . DS;

        $base = FileSystem::folder($base)->sanitize();

        return str_replace($base, '', $path);
    }

    /**
     * Carrega todas as informações da diretiva através do tema,
     * nome da diretiva e com seu tipo
     *
     * @param Theme $theme
     * @param string $sentence
     * @param string $type
     * @return void
     */
    protected function init(Theme $theme, string $sentence, string $type) : void
    {
        $this->setTheme($theme);        
        $this->setType($type);
        $this->setSentence($sentence);
        $this->setName($sentence);
        $this->setAlias();
        $this->setPath();
    }

    /**
     * Define a sentença que foi inserida pelo usuário via console,
     * que irá fornecer o nome/sub-diretório
     *
     * @param Theme $theme
     * @return Directive
     * @throws InvalidDirectiveNameException
     */
    protected function setSentence(string $sentence) : Directive
    {
        $parsed = $this->parser()->filename($sentence);

        if (! $parsed) {
            throw new InvalidDirectiveNameException($sentence);
        }

        if (! $this->valid()->directive($parsed->name)) {
            throw new InvalidDirectiveNameException($sentence);
        }

        $this->sentence = strtolower($sentence);
        return $this;
    }
    
    /**
     * Define o tipo da diretiva
     *
     * @param string $type
     * @return Directive
     * @throws InvalidDirectiveNameException
     */
    protected function setType(string $type) : Directive
    {
        if (! $this->valid()->type($type)) {
            throw new InvalidTypeDirectiveException($type);
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Define o caminho absoluto do arquivo composer.json dentro do tema
     *
     * @param string $path
     * @return Composer
     */
    protected function setPath() : Directive
    {
        $this->path = $this->filePath();
        return $this;
    }

    /**
     * Define o nome da diretiva
     *
     * @param string $name
     * @return Directive
     */
    protected function setName(string $name) : Directive
    {
        $parsed = $this->parser()->filename($name);

        $this->name = Str::slug($parsed->name);

        return $this;
    }

    /**
     * Define o alias para ser chamado dentro do projeto
     *
     * @return Directive
     */
    protected function setAlias() : Directive
    {
        $this->alias = $this->nominator()->alias($this->name);

        return $this;
    }
}