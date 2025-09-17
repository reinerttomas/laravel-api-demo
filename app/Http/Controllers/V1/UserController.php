<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('Users')]
final readonly class UserController
{
    /**
     * Index
     *
     * Returns a paginated list of users.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $users = User::query()->paginate(
            perPage: $request->integer('perPage', 15),
            page: $request->integer('page', 1)
        );

        return UserResource::collection($users);
    }

    /**
     * Show
     *
     * Returns a specific user by ID.
     */
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }
}
