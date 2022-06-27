<?php

declare(strict_types=1);

namespace Maid\Sdk\Exceptions;

use Exception;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
class RequestRequiresRedirectUriException extends Exception
{
    public function __construct($message = 'Request requires redirect uri', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
