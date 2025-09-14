<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\ValueObjects\Auth\AccessToken;
use Carbon\CarbonImmutable;

final readonly class TokenService
{
    public function createAccessToken(User $user): AccessToken
    {
        $expiresAt = CarbonImmutable::now()->addHours(24);

        $token = $user->createToken(
            name: 'AccessToken',
            expiresAt: $expiresAt,
        );

        $accessToken = str($token->plainTextToken)->explode('|')->last();

        return new AccessToken($accessToken, $expiresAt);
    }
}
