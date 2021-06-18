<?php

namespace Maestriam\Samurai\Foundation;

class SyntaxValidator
{
    /**
     * Verifica se o padrão "vendor/theme"
     * foi preenchido corretamente
     *
     * @param string $sentence
     * @return boolean
     */
    public function vendor(string $sentence) : bool
    {
        $pattern = "/^[a-z0-9_.-]+\/[a-z0-9_.-]\w+/"; 

        return (preg_match($pattern, $sentence)) ? true : false;
    }

    /**
     * Verifica se o padrão "Nome do author <email@domain>"
     * foi preenchido corretamente
     *
     * @param string $sentence
     * @return boolean
     */
    public function author(string $sentence) : bool
    {
        $pattern = "/^[a-zA-Z0-9\s_.-]+ <[\w.-_]+@+[\w-]+.*(\.[a-z]{2,3})+>$/";

        return (preg_match($pattern, $sentence)) ? true : false;
    }

    /**
     * Verifica se o padrão para o nome do tema está correto.  
     * Retorna true se estiver correto.  
     *
     * @param string $name
     * @return boolean
     */
    public function theme(string $name) : bool
    {
        $onlyValidChars = "/^[a-z0-9_.-]+$/";
        
        return (preg_match($onlyValidChars, $name)) ? true : false;
    }
    
    /**
     * Verifica se o padrão para o nome de uma diretiva está correto.  
     * Retorna true se estiver correto.  
     *
     * @param string $name
     * @return boolean
     */
    public function directive(string $name) : bool
    {
        $startNumbers   = "/^[\d]/";
        $onlyValidChars = "/^[a-zA-Z0-9\/\-]+$/";
        
        if (preg_match($startNumbers, $name)) {
            return false;
        }

        if (! preg_match($onlyValidChars, $name)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Verifica se o tipo da diretiva é um tipo aceitável pelo sistema.  
     * Retorna true se estiver correto.  
     *
     * @param string $type
     * @return boolean
     */
    public function type(string $type = null) : bool
    {   
        if (! $type) {
            return false;
        }

        $types = config('samurai.species');

        return (in_array($type, $types)) ? true : false;
    }
}
