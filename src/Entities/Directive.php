<?php

namespace Maestriam\Samurai\Entities;

use Illuminate\Support\Str;
use Maestriam\Samurai\Entities\Theme;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Maestriam\Samurai\Contracts\DirectiveContract;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
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

    public function __construct(Theme $theme, string $sentence)
    {
        $this->start($theme, $sentence, $this->type());
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
        $pattern = '%s.%s.blade';

        return sprintf($pattern, $this->sentence(), $this->type);
    }

    /**
     * {@inheritDoc}
     */
    public function placeholders() : array
    {
        return ['name' => $this->name];
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {
        $info = $this->createFile();

        $this->setPath($info->absolute_path);

        return $this;
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
    protected function start(Theme $theme, string $sentence, string $type) : void
    {
        $this->setTheme($theme);
        
        $this->setType($type)
             ->setSentence($sentence)
             ->setName($sentence)
             ->setAlias();
    }

    /**
     * Define a sentença que foi inserida pelo usuário via console,
     * que irá fornecer o nome/sub-diretório
     *
     * @param Theme $theme
     * @return self
     */
    protected function setSentence(string $sentence) : self
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
     */
    protected function setType(string $type) : self
    {
        if (! $this->valid()->type($type)) {
            throw new InvalidTypeDirectiveException($type);
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Define o caminho completo do arquivo composer.json dentro do tema
     *
     * @param string $path
     * @return Composer
     */
    protected function setPath(string $path) : Directive
    {
        if (! is_file($path)) {
            throw new \Exception('File not found');
        }

        $this->path = $path;
        return $this;
    }

    /**
      * Define o nome da diretiva
      *
      * @param string $name
      * @return Directive
      */
     protected function setName(string $name) : self
     {
         $parsed = $this->parser()->filename($name);

         $this->name = Str::slug($parsed->name);

         return $this;
     }

     /**
      * Define o alias para ser chamado dentro do projeto
      *
      * @param string $name
      * @return Directive
      */
     protected function setAlias() : self
     {
         $this->alias = $this->nominator()->alias($this->name);

         return $this;
     }
}