<?php

namespace Maid\Sdk\ApiOperations;

use Maid\Sdk\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Json
{
    abstract public function json(string $method, string $path = '', array $body = null): Result;
}
