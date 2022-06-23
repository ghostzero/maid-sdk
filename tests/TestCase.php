<?php

namespace GhostZero\Maid\Tests;

use GhostZero\Maid\Maid;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    private Maid $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Maid();

        $this->getClient()
            ->setClientId('test');
    }

    protected function getClient(): Maid
    {
        return $this->client;
    }
}
