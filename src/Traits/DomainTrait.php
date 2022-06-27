<?php

namespace Maid\Sdk\Traits;

use Maid\Sdk\Exceptions\RequestRequiresClientIdException;
use Maid\Sdk\Result;
use GuzzleHttp\Exception\GuzzleException;

trait DomainTrait
{
    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function createDomain(int $project, array $parameters): Result
    {
        return $this->post("projects/{$project}/domains", [], $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function getDomains(int $project, array $parameters = []): Result
    {
        return $this->get("projects/{$project}/domains", $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function getDomainRecords(string $domain, array $parameters = []): Result
    {
        return $this->get("domains/{$domain}/records", $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function createDomainRecord(string $domain, array $parameters = []): Result
    {
        return $this->post("domains/{$domain}/records", $parameters);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function deleteDomainRecord(string $domain, string $type, string $name): Result
    {
        return $this->delete("domains/{$domain}/records", [
            'type' => $type,
            'name' => $name,
        ]);
    }

    /**
     *
     *
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function deleteDomain(string $domain): Result
    {
        return $this->delete("domains/{$domain}");
    }
}