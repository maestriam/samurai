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
        Blade::directive('public', function ($file) : string {
                      
            $theme = Samurai::base()->current(); 
            
            if ($theme == null) {
                return null;
            }
            
            return $theme->url($file);
        });
    }
}
