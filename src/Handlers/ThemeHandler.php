<?php

namespace Maestriam\Katana\Handlers;

use Config;

class ThemeHandler
{
    /**
     * Retorna o nome para o registro como componente do Blade
     *
     * @return string
     */
    public function namespace($name) : string
    {
        $prefix = Config::get('Katana.nomenclature.prefix.theme');

        return $prefix . $name;
    }
}
