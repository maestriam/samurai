<?php

namespace Maestriam\Samurai\Support;

use Illuminate\Support\Facades\Facade;

class Samurai extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'samurai';
    }
}