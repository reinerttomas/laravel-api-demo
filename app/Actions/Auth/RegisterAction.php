<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Users\CreateUserAction;
use App\Services\TokenService;
use App\ValueObjects\Auth\TokenResult;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class RegisterAction
{
    public function __construct(
        private CreateUserAction $createUserAction,
        private TokenService $tokenService,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function handle(array $data): TokenResult
    {
        return DB::transaction(function () use ($data): TokenResult {
            $user = $this->createUserAction->handle($data);
            $accessToken = $this->tokenService->createAccessToken($user);

            return new TokenResult($user, $accessToken);
        });
    }
}
