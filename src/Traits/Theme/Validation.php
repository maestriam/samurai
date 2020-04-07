<?php

namespace Maestriam\Samurai\Traits\Theme;

/**
 *
 */
trait Validation
{
    /**
     * Retorna se é nome específicado é válido para criação
     * de um tema
     *
     * @param string $name
     * @return boolean
     */
    public function isValidName(string $name) : bool
    {
        return $this->valid()->theme($name);
    }

    /**
     * Retorna se existe o diretório do tema
     * na base de temas
     *
     * @param string $name   Nome do tema
     * @return boolean
     */
    public function exists() : bool
    {
        $theme = $this->dir()->theme($this->distributor, $this->name);

        return (is_dir($theme)) ? true : false;
    }
}













