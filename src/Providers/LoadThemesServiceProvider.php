<?php

namespace Maestriam\Samurai\Providers;

use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Traits\Themeable;

class LoadThemesServiceProvider extends ServiceProvider
{
    use Themeable;

    /**
     * Inicia o carregamento do primeiro tema que encontrar
     *
     * @return void
     */
    public function boot()
    {
        $theme = $this->base()->current();

        if ($theme == null) return false;

        return $theme->load();
    }
}
