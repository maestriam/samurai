<?php

namespace Maestriam\Samurai\Models;

class Theme
{
    /**
     * Nome da diretiva
     *
     * @var string
     */
    public $name = '';

    /**
     * Caminho do arquivo
     *
     * @var string
     */
    public $path = '';

    /**
     * Apelido para ser chamado pelo Laravel Blade
     *
     * @var string
     */
    public $namespace = '';
}
