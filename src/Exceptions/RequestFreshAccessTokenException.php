<?php

namespace GhostZero\Maid\Exceptions;

use DomainException;
use Psr\Http\Message\ResponseInterface;

/**
 * @author René Preuß <rene.p@preuss.io>
 */
class RequestFreshAccessTokenException extends DomainException
{
    protected ResponseInterface $response;

    public static function fromResponse(ResponseInterface $response): self
    {
        $instance = new self(sprintf('Refresh token request from maid id failed. Status Code is %s.', $response->getStatusCode()));
        $instance->response = $response;

        return $instance;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
