<?php

namespace Maid\Sdk;

use Exception;
use Maid\Sdk\Support\Paginator;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class Result
{
    /**
     * Query successful.
     */
    public bool $success = false;

    /**
     * Guzzle exception, if present.
     */
    public mixed $exception = null;

    /**
     * Query result data.
     */
    public array|stdClass $data = [];

    /**
     * Total amount of result data.
     */
    public int $total = 0;

    /**
     * Status Code.
     */
    public int $status = 0;

    /**
     * Maid response pagination cursor.
     */
    public ?string $next_cursor = null;

    /**
     * Maid response pagination cursor.
     */
    public ?string $prev_cursor = null;

    /**
     * Internal paginator.
     */
    public ?Paginator $paginator;

    /**
     * Original Guzzle HTTP Response.
     */
    public ?ResponseInterface $response;

    /**
     * Original Maid instance.
     */
    public Maid $maid;

    /**
     * Constructor,.
     *
     * @param ResponseInterface|null $response HTTP response
     * @param Exception|mixed $exception Exception, if present
     * @param Paginator|null $paginator Paginator, if present
     */
    public function __construct(?ResponseInterface $response, Exception $exception = null, Paginator $paginator = null)
    {
        $this->response = $response;
        $this->success = null === $exception;
        $this->exception = $exception;
        $this->status = $response ? $response->getStatusCode() : 500;
        $jsonResponse = $response ? @json_decode($response->getBody()->getContents(), false) : null;
        if (null !== $jsonResponse) {
            $this->setProperty($jsonResponse, 'data');
            $this->setProperty($jsonResponse, 'total', 0);
            $this->setProperty($jsonResponse, 'next_cursor');
            $this->setProperty($jsonResponse, 'prev_cursor');
            $this->paginator = Paginator::from($this);
        }
    }

    /**
     * Sets a class attribute by given JSON Response Body.
     *
     * @param stdClass $jsonResponse Response Body
     * @param string $responseProperty Response property name
     * @param string|null $attribute Class property name
     */
    private function setProperty(stdClass $jsonResponse, string $responseProperty, string $attribute = null): void
    {
        if (property_exists($jsonResponse, $responseProperty)) {
            $this->{$responseProperty} = $jsonResponse->{$responseProperty};
        } elseif ('data' === $responseProperty) {
            $this->{$responseProperty} = $jsonResponse;
        } else {
            $this->{$responseProperty} = $attribute;
        }
    }

    /**
     * Returns wether the query was successful.
     *
     * @return bool Success state
     */
    public function success(): bool
    {
        return $this->success;
    }

    /**
     * Get the response data, also available as public attribute.
     */
    public function data(): array|stdClass
    {
        return $this->data;
    }

    /**
     * Returns the last HTTP or API error.
     *
     * @return string Error message
     */
    public function error(): string
    {
        // TODO Switch Exception response parsing to this->data
        if (null === $this->exception || !$this->exception->hasResponse()) {
            return 'Maid API Unavailable';
        }
        $exception = (string)$this->exception->getResponse()->getBody();
        $exception = @json_decode($exception);
        if (property_exists($exception, 'message') && !empty($exception->message)) {
            return $exception->message;
        }

        return $this->exception->getMessage();
    }

    /**
     * Shifts the current result (Use for single user/video etc. query).
     */
    public function shift(): mixed
    {
        if (!empty($this->data)) {
            $data = $this->data;

            return array_shift($data);
        }

        return null;
    }

    /**
     * Return the current count of items in dataset.
     *
     * @return int Count
     */
    public function count(): int
    {
        return count((array)$this->data);
    }

    /**
     * Set the Paginator to fetch the next set of results.
     */
    public function next(): ?Paginator
    {
        return null !== $this->paginator ? $this->paginator->next() : null;
    }

    /**
     * Set the Paginator to fetch the last set of results.
     */
    public function back(): ?Paginator
    {
        return null !== $this->paginator ? $this->paginator->back() : null;
    }

    /**
     * Get rate limit information.
     *
     * @param string|null $key Get defined index
     */
    public function rateLimit(string $key = null): array|int|string|null
    {
        if (!$this->response) {
            return null;
        }
        $rateLimit = [
            'limit' => (int)$this->response->getHeaderLine('X-RateLimit-Limit'),
            'remaining' => (int)$this->response->getHeaderLine('X-RateLimit-Remaining'),
            'reset' => (int)$this->response->getHeaderLine('Retry-After'),
        ];
        if (null === $key) {
            return $rateLimit;
        }

        return $rateLimit[$key];
    }

    public function response(): ?ResponseInterface
    {
        return $this->response;
    }

    public function dump(): void
    {
        if (function_exists('dump')) {
            dump($this->status, $this->data());
        } else {
            print_r($this->data());
        }
    }
}