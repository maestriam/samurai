<?php

namespace Maestriam\Samurai\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\DirectiveHandling;

class LoadThemesServiceProvider extends ServiceProvider
{
    use ThemeHandling, DirectiveHandling;

    public function boot()
    {
        $themes = $this->theme()->all();

        foreach($themes as $theme) {

            $directives = $this->theme()->directives($theme->name);

            if (! $this->load($directives)) {
                throw new Exception('Não foi possível carregar o tema '.$theme->name);
            }
        }
    }

    public function load($directives) : bool
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
