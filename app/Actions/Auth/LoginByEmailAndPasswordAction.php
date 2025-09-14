<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\TokenService;
use App\ValueObjects\Auth\TokenResult;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final readonly class LoginByEmailAndPasswordAction
{
    public function __construct(
        private TokenService $tokenService,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): TokenResult
    {
        // Find the user by email
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        // Check if user exists and password is correct
        if ($user === null || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        // Create a new token for the user
        $accessToken = $this->tokenService->createAccessToken($user);

        return new TokenResult($user, $accessToken);
    }
}
