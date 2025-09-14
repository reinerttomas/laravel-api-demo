<?php

declare(strict_types=1);

namespace App\ValueObjects\Auth;

use Carbon\CarbonImmutable;

final readonly class AccessToken
{
    public function __construct(
        public string $token,
        public CarbonImmutable $expiresAt,
    ) {}
}
