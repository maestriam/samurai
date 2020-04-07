<?php

namespace Maestriam\Samurai\Traits\Theme;

use Maestriam\Samurai\Models\Theme;;

/**
 * Funcionalidades de acessórios(getters/setters)
 * para definição de vendor, classe Models/Theme
 */
trait Search
{
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
