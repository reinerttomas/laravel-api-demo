<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class CreateUserAction
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function handle(array $data): User
    {
        return DB::transaction(fn (): User => User::query()->create($data));
    }
}
