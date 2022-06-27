<?php

namespace Maid\Sdk\Exceptions;

use Exception;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
class RequestRequiresClientIdException extends Exception
{
    public function __construct($message = 'Request requires Client-ID', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
