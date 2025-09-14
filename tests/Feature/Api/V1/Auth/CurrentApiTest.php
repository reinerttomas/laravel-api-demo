<?php

declare(strict_types=1);

use App\Models\User;
use Tests\Structure\V1\UserStructure;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;
use function Pest\Laravel\withHeader;

describe('Current User', function (): void {
    it('can get current user when authenticated', function (): void {
        $user = User::factory()->create();

        actingAs($user);

        $responseData = getJson('/api/v1/auth/current')
            ->assertStatus(200)
            ->assertApiStructure(new UserStructure())
            ->json();

        expect($responseData)
            ->id->toBe($user->id)
            ->name->toBe($user->name)
            ->email->toBe($user->email)
            ->email_verified_at->not->toBeNull()
            ->created_at->not->toBeNull()
            ->updated_at->not->toBeNull();
    });

    it('cannot get current user when not authenticated', function (): void {
        getJson('/api/v1/auth/current')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    });

    it('cannot get current user with invalid token', function (): void {
        withHeader('Authorization', 'Bearer invalid-token')
            ->getJson('/api/v1/auth/current')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    });
});
