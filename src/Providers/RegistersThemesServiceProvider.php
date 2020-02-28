<?php

namespace Maestriam\Samurai\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Traits\Themeable;

class RegistersThemesServiceProvider extends ServiceProvider
{
    use Themeable;

    public function boot()
    {
        $themes = $this->theme()->all();

        foreach($themes as $theme) {

            $this->registerView($theme->path, $theme->namespace);
        }
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
        $views = array_merge([$source], Config::get('view.paths'));

        $this->loadViewsFrom($views, $namespace);
    }
}
