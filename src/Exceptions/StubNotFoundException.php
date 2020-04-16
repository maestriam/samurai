<?php

namespace Maestriam\Samurai\Exceptions;

use Illuminate\Support\Facades\Lang;
use Maestriam\Samurai\Exceptions\BaseException;

class StubNotFoundException extends BaseException
{
    /**
     * Define as configuração para enviar o exception
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->initialize(STUB_NOT_FOUND_CODE, $type);
    }
}
