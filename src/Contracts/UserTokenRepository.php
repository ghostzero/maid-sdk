<?php

namespace Maid\Sdk\Contracts;

interface UserTokenRepository
{
    public function getAccessToken(): ?string;
}