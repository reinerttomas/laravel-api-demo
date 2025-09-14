<?php

declare(strict_types=1);

namespace App\ValueObjects\Auth;

use App\Models\User;

final readonly class TokenResult
{
    public function __construct(
        public User $user,
        public AccessToken $accessToken,
    ) {}
}
