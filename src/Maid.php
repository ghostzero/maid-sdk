<?php

namespace GhostZero\Maid;

use GhostZero\Maid\Exceptions\RequestRequiresAuthenticationException;
use GhostZero\Maid\Exceptions\RequestRequiresClientIdException;
use GhostZero\Maid\Exceptions\RequestRequiresRedirectUriException;
use GhostZero\Maid\Contracts\UserTokenRepository;
use GhostZero\Maid\Support\Paginator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class Maid
{
    use ApiOperations\Delete;
    use ApiOperations\Get;
    use ApiOperations\Post;
    use ApiOperations\Put;
    use ApiOperations\Json;

    use Traits\CacheTrait;
    use Traits\ClusterTrait;
    use Traits\DatabaseTrait;
    use Traits\DeploymentTrait;
    use Traits\DomainTrait;
    use Traits\EnvironmentVariableTrait;
    use Traits\ProjectTrait;

    /**
     * @internal only for internal and debug purposes
     */
    public static string $baseUrl = 'https://api.k3s.maid.sh/v1/';

    /**
     * @internal only for internal and debug purposes
     */
    public static string $authBaseUrl = 'https://api.k3s.maid.sh/';

    /**
     * Guzzle is used to make http requests.
     */
    protected Client $client;

    /**
     * Paginator object.
     */
    protected Paginator $paginator;

    /**
     * Maid OAuth token.
     */
    protected ?string $token = null;

    /**
     * Maid client id.
     */
    protected ?string $clientId = null;

    /**
     * Maid client secret.
     */
    protected ?string $clientSecret = null;

    /**
     * Maid OAuth redirect url.
     */
    protected ?string $redirectUri = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::$baseUrl,
        ]);
    }

    /**
     * @param string $baseUrl
     *
     * @internal only for internal and debug purposes
     */
    public static function setBaseUrl(string $baseUrl): void
    {
        self::$baseUrl = $baseUrl;
    }

    /**
     * @param string $authBaseUrl
     *
     * @internal only for internal and debug purposes
     */
    public static function setAuthBaseUrl(string $authBaseUrl): void
    {
        self::$authBaseUrl = $authBaseUrl;
    }

    /**
     * Get client id.
     *
     * @return string
     * @throws RequestRequiresClientIdException
     *
     */
    public function getClientId(): string
    {
        if (!$this->clientId) {
            throw new RequestRequiresClientIdException();
        }

        return $this->clientId;
    }

    /**
     * Set client id.
     *
     * @param string $clientId Maid client id
     *
     * @return void
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * Fluid client id setter.
     *
     * @param string $clientId Maid client id
     *
     * @return self
     */
    public function withClientId(string $clientId): self
    {
        $this->setClientId($clientId);

        return $this;
    }

    /**
     * Get client secret.
     *
     * @return string
     * @throws RequestRequiresClientIdException
     *
     */
    public function getClientSecret(): string
    {
        if (!$this->clientSecret) {
            throw new RequestRequiresClientIdException();
        }

        return $this->clientSecret;
    }

    /**
     * Set client secret.
     *
     * @param string $clientSecret Maid client secret
     *
     * @return void
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * Fluid client secret setter.
     *
     * @param string $clientSecret Maid client secret
     *
     * @return self
     */
    public function withClientSecret(string $clientSecret): self
    {
        $this->setClientSecret($clientSecret);

        return $this;
    }

    /**
     * Get redirect url.
     *
     * @return string
     * @throws RequestRequiresRedirectUriException
     *
     */
    public function getRedirectUri(): string
    {
        if (!$this->redirectUri) {
            throw new RequestRequiresRedirectUriException();
        }

        return $this->redirectUri;
    }

    /**
     * Set redirect url.
     *
     * @param string $redirectUri
     *
     * @return void
     */
    public function setRedirectUri(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * Fluid redirect url setter.
     *
     * @param string $redirectUri
     *
     * @return self
     */
    public function withRedirectUri(string $redirectUri): self
    {
        $this->setRedirectUri($redirectUri);

        return $this;
    }

    /**
     * Get OAuth token.
     *
     * @return string Maid token
     * @return string|null
     * @throws RequestRequiresAuthenticationException
     *
     */
    public function getToken(): string
    {
        if (!$this->token) {
            throw new RequestRequiresAuthenticationException();
        }

        return $this->token;
    }

    /**
     * Set OAuth token.
     *
     * @param string $token Maid OAuth token
     *
     * @return void
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Fluid OAuth token setter (using user access token repository).
     */
    public function withUserAccessToken(): self
    {
        return $this->withToken(
            app(UserTokenRepository::class)->getAccessToken()
        );
    }

    /**
     * Fluid OAuth token setter.
     */
    public function withToken(?string $token = null): self
    {
        $this->setToken($token);

        return $this;
    }

    /**
     * @throws GuzzleException
     * @throws RequestRequiresClientIdException
     */
    public function get(string $path = '', array $parameters = [], Paginator $paginator = null): Result
    {
        return $this->query('GET', $path, $parameters, $paginator);
    }

    /**
     * @throws GuzzleException
     * @throws RequestRequiresClientIdException
     */
    public function post(string $path = '', array $parameters = [], ?array $jsonBody = null, Paginator $paginator = null): Result
    {
        return $this->query('POST', $path, $parameters, $paginator, $jsonBody);
    }

    /**
     * @throws GuzzleException
     * @throws RequestRequiresClientIdException
     */
    public function delete(string $path = '', array $parameters = [], Paginator $paginator = null): Result
    {
        return $this->query('DELETE', $path, $parameters, $paginator);
    }

    /**
     * @throws GuzzleException
     * @throws RequestRequiresClientIdException
     */
    public function put(string $path = '', array $parameters = [], ?array $jsonBody = null, Paginator $paginator = null): Result
    {
        return $this->query('PUT', $path, $parameters, $paginator, $jsonBody);
    }

    /**
     * @throws GuzzleException
     * @throws RequestRequiresClientIdException
     */
    public function json(string $method, string $path = '', array $body = null): Result
    {
        return $this->query($method, $path, [], null, $body);
    }

    /**
     * Build query & execute.
     *
     * @param string $method HTTP method
     * @param string $path Query path
     * @param array $parameters Query parameters
     * @param Paginator|null $paginator Paginator object
     * @param mixed|null $jsonBody JSON data
     *
     * @throws RequestRequiresClientIdException|GuzzleException
     */
    public function query(string $method = 'GET', string $path = '', array $parameters = [], Paginator $paginator = null, mixed $jsonBody = null): Result
    {
        if (null !== $paginator) {
            $parameters['cursor'] = $paginator->cursor();
        }
        try {
            $response = $this->client->request($method, $path, [
                'headers' => $this->buildHeaders((bool)$jsonBody),
                'query' => $this->buildQuery($parameters),
                'json' => $jsonBody ?: null,
            ]);
            $result = new Result($response, null, $paginator);
        } catch (RequestException $exception) {
            $result = new Result($exception->getResponse(), $exception, $paginator);
        }
        $result->maid = $this;

        return $result;
    }

    /**
     * Build query with support for multiple same first-dimension keys.
     */
    public function buildQuery(array $query): string
    {
        $parts = [];
        foreach ($query as $name => $value) {
            $value = (array)$value;
            array_walk_recursive($value, function ($value) use (&$parts, $name) {
                $parts[] = urlencode($name) . '=' . urlencode($value);
            });
        }

        return implode('&', $parts);
    }

    /**
     * Build headers for request.
     *
     * @param bool $json Body is JSON
     *
     * @return array
     * @throws RequestRequiresClientIdException
     *
     */
    private function buildHeaders(bool $json = false): array
    {
        $headers = [
            'Client-ID' => $this->getClientId(),
            'Accept' => 'application/json',
        ];
        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        if ($json) {
            $headers['Content-Type'] = 'application/json';
        }

        return $headers;
    }
}