<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Models\Foundation;
use Maestriam\Samurai\Foundation\DirectiveFinder;
use Maestriam\Samurai\Traits\Theme\Accessors;
use Maestriam\Samurai\Traits\Theme\Composer;
use Maestriam\Samurai\Traits\Theme\Search;
use Maestriam\Samurai\Traits\Theme\Validation;
use Maestriam\Samurai\Traits\Theme\Construction;
use Maestriam\Samurai\Traits\Theme\DirectiveHandling;

class Theme extends Foundation
{
    use Validation,
        Search,
        Accessors,
        Composer,
        Construction,
        DirectiveHandling;

    /**
     * Nome do tema para ser criado/manipulado
     *
     * @var string
     */
    private $name = '';

    /**
     * Nome do distribuidor do tema/Nome do tema
     * Ex: vendor/theme
     *
     * @var string
     */
    private $vendor = '';

    /**
     * Caminho-base do tema
     *
     * @var string
     */
    private $path = '';

    /**
     * Apelido para ser chamado pelo Laravel Blade
     *
     * @var string
     */
    private $namespace = '';

    /**
     *
     *
     * @var string
     */
    private $author = null;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $description = null;

    /**
     * Instância do classe que encontra todos as diretivas
     * de um tema
     *
     * @var DirectiveFinder
     */
    private $finder;

    /**
     * Undocumented function
     *
     * @param string $name
     */
    public function __construct(string $vendor)
    {
        $this->setVendor($vendor)->parseVendor();
    }

    /**
     * Retorna uma instância de uma diretiva de acordo
     * com os dados do nome, do tipo e do tema a qual pertence
     *
     * @param string $name  Nome da diretiva
     * @param string $type  Tipo que pertence
     * @return Directive
     */
    private function directivefy(string $name, string $type) : Directive
    {
        return new Directive($name, $type, $this);
    }

}
