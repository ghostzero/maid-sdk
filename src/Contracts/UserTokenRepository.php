<?php

namespace GhostZero\Maid\Contracts;

interface UserTokenRepository
{
    public function getAccessToken(): ?string;
}