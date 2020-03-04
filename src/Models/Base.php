<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Traits\FoundationScope;
use Maestriam\Samurai\Models\Theme;

class Base
{
    use FoundationScope;

    /**
     * Retorna todos os temas cadastrados no projeto
     *
     * @return array
     */
    public function all() : array
    {
        $themes  = [];
        $folders = $this->readBase();

        if (empty($folders)) {
            return $themes;
        }

        foreach($folders as $folder) {

            $theme = $this->themefy($folder);

            if ($theme == null) continue;

            $themes[] = $theme;
        }

        return $themes;
    }

    /**
     * Retorna o primeiro tema cadastrado no projeto
     *
     * @return Theme|null
     */
    public function first() : ?Theme
    {
        $folders = $this->readBase();

        if (empty($folders)) {
            return null;
        }

        $name = array_shift($folders);

        return $this->themefy($name);
    }

    /**
     * Retorna o tema atual selecionado
     *
     * @return Theme|null
     */
    public function current() : ?Theme
    {
        $key  = $this->config()->env();
        $name = $this->env()->get($key);

        if ($name != null) {
            return $this->themefy($name);
        }

        $first = $this->first();

        if ($first != null) {
            return $first;
        }

        return null;
    }

    /**
     * Retorna o objeto de um tema de acordo com um nome específico
     *
     * @param string $name
     * @return Theme
     */
    private function themefy(string $name) : ?Theme
    {
        $theme = new Theme($name);

        return $theme->get();
    }

    /**
     * Retorna a lista de todos as pastas criadas dentro
     * da base de temas do projeto
     *
     * @return void
     */
    private function readBase() : array
    {
        $base = $this->dir()->base();

        if (! is_dir($base)) return [];

        $themes = scandir($base);
        $themes = array_splice($themes, 2);

        return empty($themes) ? [] : $themes;
    }
}
