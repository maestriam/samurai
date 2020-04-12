<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Models\Foundation;
use Maestriam\Samurai\Traits\Theme\Search;
use Maestriam\Samurai\Traits\Shared\Composer;
use Maestriam\Samurai\Traits\Theme\Validation;
use Maestriam\Samurai\Traits\Theme\Construction;
use Maestriam\Samurai\Foundation\DirectiveFinder;
use Maestriam\Samurai\Traits\Theme\DirectiveHandling;
use Maestriam\Samurai\Traits\Shared\BasicAccessors;
use Maestriam\Samurai\Traits\Theme\Accessors as ThemeAccessors;

class Theme extends Foundation
{
    use Validation,
        Search,
        Composer,
        Construction,
        ThemeAccessors,
        BasicAccessors,
        DirectiveHandling;

    /**
     * Nome do tema para ser criado/manipulado
     *
     * @var string
     */
    public $name = '';

    /**
     * Nome do distribuidor do tema/Nome do tema
     * Ex: vendor/theme
     *
     * @var string
     */
    public $vendor = '';

    /**
     * Caminho-base do tema
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

    /**
     *
     *
     * @var string
     */
    public $author = null;

    /**
     * Undocumented variable
     *
     * @var string
     */
    public $description = null;

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

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return void
     */
    public function author(string $author)
    {
        return $this->setAuthor($author);
    }

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return void
     */
    public function description(string $description)
    {
        return $this->setDescription($description);
    }
}
