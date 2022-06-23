<?php

namespace GhostZero\Maid\Tests;

use GhostZero\Maid\Exceptions\RequestRequiresClientIdException;
use GuzzleHttp\Exception\GuzzleException;

class EnvironmentTest extends TestCase
{
    /**
     * @throws RequestRequiresClientIdException
     * @throws GuzzleException
     */
    public function test()
    {
        $result = $this->getClient()->setEnvironmentVariables(1, [[
            'environment' => 'local',
            'key' => 'APP_NAME',
            'value' => 'Hello World',
        ]]);

        $result->dump();
    }
}