<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Facades\Artisan;

class FileSystem
{
    /**
     * Limpa o cache do projeto
     *
     * @return void
     */
    public function clearCache()
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return true;
    }
}
