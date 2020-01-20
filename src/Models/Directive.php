<?php

namespace Maestriam\Samurai\Models;

class Directive
{
    /**
     * Nome da diretiva
     *
     * @var string
     */
    public $name = '';

    /**
     * Tipo da diretiva
     *
     * @var string
     */
    public $type = '';

    /**
     * Tema de origem
     *
     * @var Theme
     */
    public $theme;

    /**
     * Caminho do arquivo
     *
     * @var string
     */
    public $path = '';
}
