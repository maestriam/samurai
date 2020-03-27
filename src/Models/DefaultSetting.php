<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Foundation;

class DefaultSetting extends Foundation
{
    /**
     * Retorna o nome do vendor/nome do tema sugerido
     * de acordo com as configurações do projeto
     *
     * @return void
     */
    public function name() : string
    {
        $author = $this->config()->author();
        $vendor = $author->vendor;
        $theme  = $this->dir()->project();
        
        return $vendor .'/'. $theme . '-theme';
    }

    /**
     * Retorna o e-mail do autor de acordo com as
     *
     * @return void
     */
    public function author() : object
    {
        return $this->config()->author();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function description() : string
    {
        $project = $this->dir()->project();

        $desc = sprintf("Theme for project '%s'", $project);

        return $desc;
    }
}
