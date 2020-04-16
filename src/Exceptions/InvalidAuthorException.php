<?php

namespace Maestriam\Samurai\Exceptions;

use Maestriam\Samurai\Exceptions\BaseException;

class InvalidAuthorException extends BaseException
{
    public function __construct($author)
    {
        $this->initialize(INVALID_AUTHOR_CODE, $author);
    }
}

