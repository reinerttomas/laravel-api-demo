<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\Auth\LoginByEmailAndPasswordAction;
use App\Http\Requests\V1\Auth\LoginByEmailAndPasswordRequest;
use App\Http\Resources\V1\Auth\TokenResource;
use Dedoc\Scramble\Attributes\Group;

#[Group(name: 'Auth')]
final readonly class LoginByEmailAndPasswordController
{
    public function __construct(
        private LoginByEmailAndPasswordAction $loginByEmailAndPasswordAction,
    ) {}

    /**
     * Login
     *
     * Authenticate user by email and password.
     */
    public function __invoke(LoginByEmailAndPasswordRequest $request): TokenResource
    {
        return TokenResource::make($this->loginByEmailAndPasswordAction->handle($request->validated()));
    }
}
