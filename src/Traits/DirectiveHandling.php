<?php

namespace Maestriam\Katana\Traits;

use Maestriam\Katana\Handlers\DirectiveHandler;

trait DirectiveHandling
{

    /**
     * Retorna uma instância do serviço de manipulação
     * de diretivas
     *
     * @return void
     */
    public function directive()
    {
        return new DirectiveHandler();
    }
}
