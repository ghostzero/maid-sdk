<?php

namespace Maid\Sdk\Traits;

use Maid\Sdk\Exceptions\RequestRequiresClientIdException;
use Maid\Sdk\Result;
use GuzzleHttp\Exception\GuzzleException;

trait CacheTrait
{
    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function createCache(int $project, array $parameters): Result
    {
        return $this->post("projects/{$project}/caches", [], $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function getCaches(int $project, array $parameters = []): Result
    {
        return $this->get("projects/{$project}/caches", $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function deleteCache(int $cache): Result
    {
        return $this->delete("caches/{$cache}");
    }
}