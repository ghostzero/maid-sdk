<?php

namespace Maid\Sdk\ApiOperations;

use Maid\Sdk\Support\Paginator;
use Maid\Sdk\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Delete
{
    abstract public function delete(string $path = '', array $parameters = [], Paginator $paginator = null): Result;
}
