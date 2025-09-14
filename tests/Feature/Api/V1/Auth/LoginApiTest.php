<?php

declare(strict_types=1);

use App\Models\User;
use Tests\Structure\V1\Auth\TokenStructure;

use function Pest\Laravel\postJson;

describe('Login', function (): void {
    it('can login with valid credentials', function (): void {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        postJson('/api/v1/auth/login', $data)
            ->assertStatus(200)
            ->assertApiStructure(new TokenStructure());
    });

    it('cannot login with invalid email', function (): void {
        User::factory()->create();

        $data = [
            'email' => 'wrong@example.com',
            'password' => 'password123',
        ];

        postJson('/api/v1/auth/login', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => [trans('auth.failed')],
            ]);
    });

    it('cannot login with invalid password', function (): void {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        postJson('/api/v1/auth/login', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => [trans('auth.failed')],
            ]);
    });

    it('requires valid email format', function (): void {
        $data = [
            'email' => 'invalid-email',
            'password' => 'password123',
        ];

        postJson('/api/v1/auth/login', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });
});
