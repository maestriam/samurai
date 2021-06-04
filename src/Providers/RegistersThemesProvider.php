<?php

namespace Maestriam\Samurai\Providers;

use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Support\Samurai;

class RegistersThemesProvider extends ServiceProvider
{
    public function boot()
    {
        $theme = Samurai::base()->any();

        if ($theme == null) {
            return false;
        }
        
        $this->registerView($theme->paths()->root(), $theme->namespace());
    }

    /**
     * Registra um caminho como parte da base de views
     * do Laravel
     *
     * @param string $source
     * @param string $namespace
     * @return void
     */
    protected function registerView($source, $namespace)
    {
        $views = array_merge([$source], config('view.paths'));
        
        $this->loadViewsFrom($views, $namespace);
    }
}
