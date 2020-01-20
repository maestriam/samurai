<?php

namespace Maestriam\Samurai\Traits;

use Maestriam\Samurai\Handlers\DirectiveHandler;

trait DirectiveHandling
{

    protected static $directiveHanlder;

    /**
     * Retorna uma instancia singleton de directive
     *
     * @return void
     */
    private function directive() : DirectiveHandler
    {
        if (! isset(static::$directiveHanlder)) {
            static::$directiveHanlder = new DirectiveHandler();
        }

        return static::$directiveHanlder;
    }
}
