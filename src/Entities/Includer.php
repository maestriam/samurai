<?php

namespace Maestriam\Samurai\Entities;

class Includer extends Directive
{
    /**
     * Nome do template
     */
    protected string $template = 'include';

    /**
     * Nome da diretiva
     */
    protected string $name;

    /**
     * Tipo da diretiva tratada
     */
    protected string $type = 'include';

    /**
     * Nome, diretório e extensão da diretiva completa
     */
    protected string $sentence;

    public function __construct(Theme $theme, string $sentence)
    {
        $this->start($theme, $sentence, $this->type);
    }
    
    public function filename() : string
    {        
        $pattern = '%s.%s.blade';

        return sprintf($pattern, $this->sentence(), $this->type);
    }

    public function placeholders() : array
    {
        return ['name' => $this->name];
    }

    public function create()
    {
        $info = $this->createFile();

        $this->setPath($info->absolute_path);

        return $this;
    }
}