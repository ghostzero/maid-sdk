<?php

namespace Maid\Sdk\Traits;

use Maid\Sdk\Exceptions\RequestRequiresClientIdException;
use Maid\Sdk\Result;
use GuzzleHttp\Exception\GuzzleException;

trait ProjectTrait
{
    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function createProject(array $parameters): Result
    {
        return $this->post("projects", [], $parameters);
    }
}