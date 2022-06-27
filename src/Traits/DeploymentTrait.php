<?php

namespace Maid\Sdk\Traits;

use Maid\Sdk\Exceptions\RequestRequiresClientIdException;
use Maid\Sdk\Result;
use GuzzleHttp\Exception\GuzzleException;

trait DeploymentTrait
{
    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function createDeployment(int $project, array $parameters): Result
    {
        return $this->post("projects/{$project}/deployments", [], $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function rollbackLatestDeployment(int $project, array $parameters): Result
    {
        return $this->post("projects/{$project}/deployments/rollback", [], $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function rollbackDeployment(int $project, int $deployment): Result
    {
        return $this->post("projects/{$project}/deployments/{$deployment}/rollback");
    }
}