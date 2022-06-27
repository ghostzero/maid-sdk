<?php

namespace Maid\Sdk\ApiOperations;

use Maid\Sdk\Support\Paginator;
use Maid\Sdk\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Get
{
    abstract public function get(string $path = '', array $parameters = [], Paginator $paginator = null): Result;
}
