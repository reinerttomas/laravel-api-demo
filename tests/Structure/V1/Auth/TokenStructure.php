<?php

declare(strict_types=1);

namespace Tests\Structure\V1\Auth;

use Tests\Structure\Structure;
use Tests\Structure\V1\UserStructure;

final readonly class TokenStructure extends Structure
{
    public function toArray(): array
    {
        return [
            'access_token',
            'type',
            'expires_at',
            'user' => new UserStructure,
        ];
    }
}
