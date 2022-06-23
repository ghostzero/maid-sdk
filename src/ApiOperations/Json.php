<?php

namespace GhostZero\Maid\ApiOperations;

use GhostZero\Maid\Result;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
trait Json
{
    abstract public function json(string $method, string $path = '', array $body = null): Result;
}
