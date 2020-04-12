<?php

namespace Maestriam\Samurai\Exceptions;

use Maestriam\Samurai\Exceptions\BaseException;

class InvalidAuthorException extends BaseException
{
    public function __construct()
    {
        $this->initialize(INVALID_AUTHOR_CODE);
    }
}

