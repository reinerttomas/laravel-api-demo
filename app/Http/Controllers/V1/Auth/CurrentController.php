<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Container\Attributes\CurrentUser;

#[Group(name: 'Auth')]
final class CurrentController
{
    /**
     * Current
     *
     * Get the currently authenticated user.
     */
    public function __invoke(#[CurrentUser] User $user): UserResource
    {
        return UserResource::make($user);
    }
}
