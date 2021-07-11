<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\File;
use Maestriam\Samurai\Entities\Theme;

class ThemePublisher
{
    private Theme $themeInstance;

    public function __construct(Theme $theme)
    {
        $this->setTheme($theme);
    }    

    public function publish()
    {
        $from = $this->theme()->paths()->assets();
        $to   = $this->theme()->paths()->public();

        File::copyDirectory($from, $to);

        return (is_dir($to)) ? true : false;
    }

    private function theme() : Theme 
    {
        return $this->themeInstance;
    }

    private function setTheme(Theme $theme) : ThemePublisher
    {
        $this->themeInstance = $theme;
        return $this;        
    }
}