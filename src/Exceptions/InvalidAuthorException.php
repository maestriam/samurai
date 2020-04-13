<?php

namespace Maestriam\Samurai\Exceptions;

use Maestriam\Samurai\Exceptions\BaseException;

class InvalidAuthorException extends BaseException
{
    public function __construct($author)
    {
        $this->setCode(INVALID_AUTHOR_CODE);
        $this->setMessage(INVALID_AUTHOR_CODE, $author);
    }
}

