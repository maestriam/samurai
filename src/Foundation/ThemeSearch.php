<?php

namespace Maestriam\Samurai\Foundation;

class ThemeSearch
{
    

    /**
     * Retorna uma instância de uma diretiva de acordo
     * com os dados do nome, do tipo e do tema a qual pertence
     *
     * @param  string $name Nome da diretiva
     * @param  string $type Tipo que pertence
     * @return Directive
     */
    private function directivefy(string $name, string $type) : Directive
    {
        return new Directive($name, $type, $this);
    }

    /**
     * Retorna se existe o diretório do tema
     * na base de temas
     *
     * @param  string $name Nome do tema
     * @return boolean
     */
    public function exists() : bool
    {
        $theme = $this->dir()->theme($this->distributor, $this->name);

        return (is_dir($theme)) ? true : false;
    }

    /**
     * Tenta encontrar um tema questão
     * Caso não encontre, constua-o
     *
     * @return Theme
     */
    public function findOrBuild() : Theme
    {
        if (! $this->exists()) {
            return $this->build();
        }

        return $this->get();
    }

    /**
     * Retorna a instância de um tema
     * se caso o tema existir
     *
     * @return Theme|null
     */
    public function get() : ?Theme
    {
        if (! $this->exists()) {
            return null;
        }

        return $this;
    }    
}
