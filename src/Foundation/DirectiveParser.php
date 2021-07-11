<?php

namespace Maestriam\Samurai\Foundation;

use Maestriam\Samurai\Entities\Directive;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException;
use Maestriam\Samurai\Contracts\Foundation\DirectiveParserContract;
use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Includer;

class DirectiveParser implements DirectiveParserContract
{

   
    private SyntaxValidator $validator;

    private Theme $theme;

    private string $type;

    private string $sentence;

    private string $relative;

    private string $name;

    public function __construct(Theme $theme)
    {
        $this->setValidator()->setTheme($theme);
    }

    /**
     * Recupera todas as informações de um diretiva atráves do seu caminho completo.  
     *
     * @param  string $file
     * @return void
     */
    public function parse(string $file) : DirectiveParser
    {
        $this->setFile($file)
            ->setRelative()
            ->setNameAndType()
            ->setSentence();
            
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toObject() : object
    {
        return (object) [
            'relative' => $this->relative,
            'sentence' => $this->sentence,
            'name'     => $this->name,
            'type'     => $this->type
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function toDirective() : Component|Includer
    {
        return ($this->type == 'component') ? $this->toComponent() : $this->toIncluder();
    }

    /**
     * Retorna a instância de uma diretiva includer, de acordo com o tema e a sentença.  
     *
     * @return Includer
     */
    private function toIncluder() : Includer
    {
        return new Includer($this->theme(), $this->sentence);
    }

    /**
     * Retorna a instância de uma diretiva component, de acordo com o tema e a sentença.  
     *
     * @return Component
     */
    private function toComponent() : Component
    {
        return new Component($this->theme(), $this->sentence);
    }

    /**
     * Retorna o tema específico
     *
     * @return Theme
     */
    private function theme() : Theme
    {
        return $this->theme;
    }

    /**
     * Define o tema que será utilizado para manipulação
     *
     * @param  Theme $theme
     * @return DirectiveParser
     */
    private function setTheme(Theme $theme) : DirectiveParser
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Retorna o validador de nomenclatura de entidades do pacote.  
     *
     * @return SyntaxValidator
     */
    private function validator() : SyntaxValidator
    {        
        return $this->validator;
    }
    
    /**
     * Define a instancia do validador
     *
     * @return DirectiveParser
     */
    private function setValidator() : DirectiveParser
    {
        $this->validator = new SyntaxValidator();
        return $this;
    }

    /**
     * Define o arquivo que será interpretado.  
     *
     * @param  string $file
     * @return DirectiveParser
     */
    private function setFile(string $file) : DirectiveParser
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Extrai o caminho relativo da diretiva através do caminho completo 
     * do arquivo.  
     *
     * @return DirectiveParser
     */
    private function setRelative() : DirectiveParser
    {
        $source = $this->theme()->paths()->source();

        $this->relative = str_replace($source, '', $this->file);
        return $this;
    }

    /**
     * Extrai o tipo de diretiva atráves do caminho absoluto.  
     *
     * @return DirectiveParser
     */
    private function setNameAndType() : DirectiveParser
    {
        $file = str_replace('.php', '', $this->relative);
        $info = pathinfo($file);
        $part = explode('-', $info['filename']);

        $this->type = array_pop($part);

        if (! $this->validator()->type($this->type)) {
            throw new InvalidTypeDirectiveException($this->type);
        }

        $this->name = implode('-', $part);
        
        return $this;
    }

    /**
     * Extrai a sentença da diretiva.  
     *
     * @return DirectiveParser
     */
    private function setSentence() : DirectiveParser
    {
        $search = '-' . $this->type. '.blade';

        $sentence = str_replace($search, '', $this->relative);
        $sentence = str_replace('.php', '', $sentence);

        $this->sentence = str_replace('\\', '/', $sentence);

        return $this;
    }
}
