<?php

namespace Maid\Sdk\ApiOperations;

use Maid\Sdk\Support\Paginator;
use Maid\Sdk\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Put
{
    abstract public function put(string $path = '', array $parameters = [], ?array $jsonBody = null, Paginator $paginator = null): Result;
}
