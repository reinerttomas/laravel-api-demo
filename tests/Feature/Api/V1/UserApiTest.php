<?php

declare(strict_types=1);

use App\Models\User;
use Tests\Structure\V1\UserStructure;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

describe('Index', function (): void {
    it('returns a paginated list of users', function (): void {
        $users = User::factory()->count(3)->create();

        actingAs($users[0])
            ->getJson('/api/v1/users')
            ->assertStatus(200)
            ->assertPaginatedApiCount(3)
            ->assertPaginatedApiStructure(new UserStructure);
    });

    it('fails 401 when not authenticated', function (): void {
        getJson('/api/v1/users')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    });
});

describe('Show', function (): void {
    it('returns a specific user', function (): void {
        $user = User::factory()->create();

        actingAs($user)
            ->getJson("/api/v1/users/$user->id")
            ->assertStatus(200)
            ->assertApiStructure(new UserStructure);
    });

    it('fails 401 when not authenticated', function (): void {
        getJson('/api/v1/users/1')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    });
});
