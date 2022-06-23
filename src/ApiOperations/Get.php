<?php

namespace GhostZero\Maid\ApiOperations;

use GhostZero\Maid\Support\Paginator;
use GhostZero\Maid\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Get
{
    abstract public function get(string $path = '', array $parameters = [], Paginator $paginator = null): Result;
}
