<?php

namespace Maid\Sdk\Traits;

use Maid\Sdk\Exceptions\RequestRequiresClientIdException;
use Maid\Sdk\Result;
use Maid\Sdk\Support\Paginator;
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

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function deleteCluster(int $cluster): Result
    {
        return $this->delete("clusters/{$cluster}");
    }
}