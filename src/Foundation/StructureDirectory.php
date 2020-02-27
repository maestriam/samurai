<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class StructureDirectory
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function base()
    {
        $samurai = Config::get('Samurai.themes.folder');

        return $samurai;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return string
     */
    public function theme(string $name) : string
    {
        $base = $this->base();
        $name = strtolower($name);

        return $base . DS . $name;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function assets(string $name)
    {
        $assets = Config::get('Samurai.themes.assets');

        return $this->theme($name) . DS . $assets;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function files(string $name)
    {
        $files = Config::get('Samurai.themes.assets');

        return $this->theme($name) . DS . $files;
    }
}
