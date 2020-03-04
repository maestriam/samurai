<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Config;

class ConfigKeeper
{
    public function env()
    {
        return Config::get('Samurai.env_key');
    }
}
