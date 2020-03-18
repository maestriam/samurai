<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Foundation;

class Base extends Foundation
{
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
     * Limpa o cache dos arquivos de view do projeto
     *
     * @return void
     */
    public function clearCache()
    {
        return $this->file()->clearCache();
    }

    /**
     * Retorna o nome do vendor/nome do tema sugerido
     * de acordo com as configurações do projeto
     *
     * @return void
     */
    public function suggestName() : string
    {
        $author = $this->config()->author();
        $vendor = $author->vendor;
        $theme  = $this->dir()->project();
        
        return $vendor .'/'. $theme . '-theme';
    }

    /**
     * Retorna o e-mail do autor de acordo com as
     *
     * @return void
     */
    public function author() : object
    {
        return $this->config()->author();
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
