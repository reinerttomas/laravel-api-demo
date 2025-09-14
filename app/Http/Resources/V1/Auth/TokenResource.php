<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Auth;

use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\ValueObjects\Auth\TokenResult
 */
final class TokenResource extends JsonResource
{
    public static $wrap;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->accessToken->token,
            'type' => 'Sanctum',

            /**
             * Expiration timestamp of token.
             *
             * @var \Carbon\CarbonImmutable
             */
            'expires_at' => $this->accessToken->expiresAt,

            'user' => UserResource::make($this->user),
        ];
    }
}
