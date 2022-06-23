<?php

namespace GhostZero\Maid\Traits;

use GhostZero\Maid\ApiOperations\Get;
use GhostZero\Maid\Exceptions\RequestRequiresClientIdException;
use GhostZero\Maid\Result;
use GhostZero\Maid\Support\Paginator;
use GuzzleHttp\Exception\GuzzleException;

trait EnvironmentVariableTrait
{
    use Get;

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function setEnvironmentVariables(int $project, array $variables): Result
    {
        return $this->post("projects/{$project}/environment-variables", [], $variables);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function getEnvironmentVariables(int $project, string $environment, Paginator $paginator = null): Result
    {
        return $this->get("projects/{$project}/environment-variables", [
            'environment' => $environment,
        ], $paginator);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function flushEnvironmentVariables(int $project, string $environment): Result
    {
        return $this->delete("projects/{$project}/environment-variables", [
            'environment' => $environment,
        ]);
    }
}