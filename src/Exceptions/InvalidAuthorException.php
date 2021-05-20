<?php

namespace Maestriam\Samurai\Exceptions;

use Maestriam\Samurai\Exceptions\BaseException;

class InvalidAuthorException extends BaseException
{
    public function __construct($author)
    {
        $msg = 'The author name "%s" is an invalid author name. E.g: Name <email@host.com>';
        
        $this->initialize(0104, $msg, $author);
    }
}