<?php

namespace Maestriam\Samurai\Concerns;

use Maestriam\Samurai\Foundation\FileNominator;

trait WithFileNominator
{
    /**
     * Classe auxiliar para nomeação de diretivas/namespaces
     * de acordo com as regras negócios do Blade
     *
     * @var FileNominator
     */
    private $nominator;
    
    /**
     * Função auxiliar para nomeação de diretivas/namespaces 
     * de acordo com as regras negócios do Blade
     * 
     * @return  FileNominator
     */
    protected function nominator() : FileNominator
    {
        if ($this->nominator == null) {
            $this->nominator = new FileNominator();
        }

        return $this->nominator;
    }
}