<?php

namespace GhostZero\Maid\ApiOperations;

use GhostZero\Maid\Support\Paginator;
use GhostZero\Maid\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Put
{
    abstract public function put(string $path = '', array $parameters = [], ?array $jsonBody = null, Paginator $paginator = null): Result;
}
