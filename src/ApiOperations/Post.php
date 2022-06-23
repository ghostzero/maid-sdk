<?php

namespace GhostZero\Maid\ApiOperations;

use GhostZero\Maid\Support\Paginator;
use GhostZero\Maid\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Post
{
    abstract public function post(string $path = '', array $parameters = [], ?array $jsonBody = null, Paginator $paginator = null): Result;
}
