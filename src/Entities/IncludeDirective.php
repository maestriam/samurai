<?php

namespace Maestriam\Samurai\Entities;

class IncludeDirective extends Directive
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
     * Nome, diretório e extensão da diretiva completa
     */
    protected string $sentence;

    public function __construct(Theme $theme, string $sentence)
    {
        $this->start($theme, $sentence, 'include');
    }

    public function filename() : string
    {
        $filename = $this->sentence() . '.include.blade';

        return ;
    }

    public function placeholders() : array
    {
        return [];
    }
}