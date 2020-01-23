<?php

namespace Maestriam\Samurai\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\DirectiveHandling;

class LoadThemesServiceProvider extends ServiceProvider
{
    use ThemeHandling, DirectiveHandling;

    /**
     * Inicia o carregamento do primeiro tema que encontrar
     *
     * @return void
     */
    public function boot()
    {
        $theme = $this->theme()->first();

        if ($theme == null) {
            return false;
        }

        $directives = $this->theme()->directives($theme->name);

        if (! $this->load($directives)) {
            throw new Exception('Não foi possível carregar o tema '.$theme->name);
        }
    }

    /**
     * Carrega todas as diretivas de um tema
     *
     * @param array $directives
     * @return boolean
     */
    public function load(array $directives) : bool
    {
        $valid = true;
        $types = $this->directive()->types();

        foreach($types as $type) {
            foreach ($directives[$type] as $directive) {
                $check = $this->directive()->load($directive);
                if ($check == false) {
                    $valid = false;
                }
            }
        }

        return $valid;
    }
}
