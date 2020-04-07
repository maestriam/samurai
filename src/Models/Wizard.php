<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Models\Foundation;

class Wizard extends Foundation
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function theme()
    {
        $theme    = $this->defaultVendor();
        $question = sprintf('Name (<vendor/name>) [%s]', $theme);

        return (object) [
            'key'     => 'theme',
            'ask'     => $question,
            'default' => $theme
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function description()
    {
        $desc     = $this->defaultDesc();
        $question = sprintf("Description [%s]", $desc);

        return (object) [
            'key'     => 'description',
            'ask'     => $question,
            'default' => $desc
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function author()
    {
        $author = $this->defaultAuthor();
        $ask    = sprintf('Author [%s]', $author);

        return (object) [
            'key'     => 'author',
            'ask'     => $ask,
            'default' => $author
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
