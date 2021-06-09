<?php

namespace Maestriam\Samurai\Exceptions;

use Maestriam\Samurai\Exceptions\BaseException;

class InvalidAuthorException extends BaseException
{
    public function __construct($author)
    {        
        $this->initialize($author);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage() : string
    {
        return 'The author name [%s] is an invalid author name. E.g: Name <email@host.com>';
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorCode() : string
    {
        return 0104;
    }
}