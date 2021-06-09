<?php

namespace Maestriam\Samurai\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Support\Samurai;

class RegistersCustomDirectiveProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPublic();
    }

    /**
     * Registra a diretiva para retornar o diretório publico
     * do assets do tema
     *
     * @return void
     */
    protected function registerPublic()
    {             
        Blade::directive('public', function ($file) {
                      
            $theme = Samurai::base()->current(); 
            
            if ($theme == null) {
                return null;
            }
            
            $file   = str_replace("'", "", $file);
            $domain = $theme->paths()->public();
            return "$domain/$file";
        });
    }
}
