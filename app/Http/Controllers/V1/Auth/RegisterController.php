<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\Auth\RegisterAction;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\Auth\TokenResource;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

#[Group(name: 'Auth')]
final readonly class RegisterController
{
    public function __construct(
        private RegisterAction $registerAction,
    ) {}

    /**
     * Register
     *
     * Register a new user.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        return TokenResource::make($this->registerAction->handle($request->validated()))
            ->response()
            ->setStatusCode(201);
    }
}
