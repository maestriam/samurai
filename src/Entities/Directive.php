<?php

namespace Maestriam\Samurai\Entities;

use Illuminate\Support\Str;
use Maestriam\Samurai\Entities\Theme;
use Illuminate\Support\Facades\Blade;
use Maestriam\Samurai\Entities\Foundation;
use Illuminate\View\Compilers\BladeCompiler;
use Maestriam\Samurai\Contracts\DirectiveContract;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
use Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException;
use stdClass;

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
        $this->setType($type)
             ->setSentence($sentence)
             ->setTheme($theme);
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
}



            //  ->setType($type)
            //  ->setName($sentence)
            //  ->setAlias($sentence)
            //  ->setFilename()
            //  ->setFolder($sentence)
            //  ->setPath($sentence);


// /**
//      * Undocumented function
//      *
//      * @param string $name
//      * @return Directive
//      */
//     protected function setName(string $name) : self
//     {
//         $request = $this->parser()->filename($name);

//         $this->name = Str::slug($request->name);
//         return $this;
//     }

//     /**
//      * Undocumented function
//      *
//      * @param string $name
//      * @return Directive
//      */
//     protected function setAlias(string $name) : self
//     {
//         $this->alias = $this->nominator()->alias($this->name);
//         return $this;
//     }

//     /**
//      *
//      *
//      * @param string $folder
//      * @return void
//      */
//     protected function setFolder(string $name) : self
//     {
//         $request = $this->parser()->filename($name);

//         $this->folder = strtolower($request->folder);
//         return $this;
//     }

//     /**
//      * Define o nome do arquivo para ser chamado no projeto
//      *
//      * @param string $name
//      * @return void
//      */
//     protected function setFilename() : self
//     {
//         $file = $this->nominator()->filename($this->name, $this->type);

//         $this->filename = $file;
//         return $this;
//     }



