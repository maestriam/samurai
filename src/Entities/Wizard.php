<?php

namespace Maestriam\Samurai\Entities;

use stdClass;
use Maestriam\Samurai\Entities\Foundation;
use Maestriam\Samurai\Traits\Shared\Composer;
use Maestriam\Samurai\Traits\Shared\BasicAccessors;

class Wizard extends Foundation
{
    use BasicAccessors, Composer;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function theme() : stdClass
    {
        $theme    = $this->defaultVendor();
        $question = sprintf('Name (<vendor/name>) [%s]', $theme);

        return (object) [
            'ask'     => $question,
            'default' => $theme
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function description() : stdClass
    {
        $desc     = $this->defaultDesc();
        $question = sprintf("Description [%s]", $desc);

        return (object) [
            'ask'     => $question,
            'default' => $desc
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function author() : stdClass
    {
        $author = $this->defaultAuthor();
        $ask    = sprintf('Author [%s]', $author);

        return (object) [
            'ask'     => $ask,
            'default' => $author
        ];
    }

    /**
     * Undocumented function
     *
     * @param string $vendor
     * @param string $author
     * @param string $desc
     * @return stdClass
     */
    public function confirm($vendor, $author, $desc) : stdClass
    {
        $this->setVendor($vendor)
             ->setAuthor($author)
             ->setDescription($desc);

        $preview = $this->getComposer();
        $ask     = 'Confirm? '. PHP_EOL . $preview;

        return (object) [
            'ask'     => $ask,
            'default' => false
        ];
    }

    /**
     * Retorna um vendor padrão para a criação
     * do tema
     *
     * @return string
     */
    private function defaultVendor() : string
    {
        $author = $this->config()->author();
        $vendor = $author->vendor;
        $theme  = $this->dir()->project();

        return $vendor .'/'. $theme . '-theme';
    }

    /**
     * Retorna uma descrição padrão para o tema
     *
     * @return string
     */
    private function defaultDesc() : string
    {
        $project = $this->dir()->project();

        return sprintf("Theme for project '%s'", $project);
    }

    /**
     * Retorna um autor padrão para a criação
     * do tema
     *
     * @return string
     */
    private function defaultAuthor() : string
    {
        $author  = $this->config()->author();
        $name    = $author->name;
        $email   = $author->email;

        return sprintf("%s <%s>", $name, $email);
    }
}
