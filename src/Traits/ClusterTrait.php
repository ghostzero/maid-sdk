<?php

namespace GhostZero\Maid\Traits;

use GhostZero\Maid\Exceptions\RequestRequiresClientIdException;
use GhostZero\Maid\Result;
use GhostZero\Maid\Support\Paginator;
use GuzzleHttp\Exception\GuzzleException;

trait ClusterTrait
{
    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function importCluster(array $parameters): Result
    {
        return $this->post("clusters/import", [], $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function getClusters(array $parameters = [], Paginator $paginator = null): Result
    {
        return $this->get('clusters', $parameters, $paginator);
    }
}