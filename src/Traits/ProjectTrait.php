<?php

namespace GhostZero\Maid\Traits;

use GhostZero\Maid\Exceptions\RequestRequiresClientIdException;
use GhostZero\Maid\Result;
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