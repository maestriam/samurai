<?php

namespace Maestriam\Samurai\Providers;

use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Support\Samurai;

class LoadThemesServiceProvider extends ServiceProvider
{
    /**
     * Inicia o carregamento do primeiro tema que encontrar
     *
     * @return void
     */
    public function boot()
    {
        $theme = Samurai::base()->current();

        if ($theme == null) { return false;
        }

        return $theme->load();
    }
}
