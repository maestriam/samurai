<?php

namespace Maestriam\Samurai\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Traits\Themeable;

class RegistersCustomDirectiveProvider extends ServiceProvider
{
    use Themeable;

    public function boot()
    {
        $this->registerPublic();
    }

    /**
     * Registra a diretiva para retorna o diretório publico
     * do assets do tema
     *
     * @return void
     */
    protected function registerPublic()
    {
        Blade::directive('public', function ($file) {
            $file   = str_replace("'", "", $file);
            $domain = $this->base()->current()->public();
            return "$domain/$file";
        });
    }
}
