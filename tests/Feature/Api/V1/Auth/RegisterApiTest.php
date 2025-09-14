<?php

declare(strict_types=1);

use App\Models\User;
use Tests\Structure\V1\Auth\TokenStructure;

use function Pest\Laravel\postJson;

describe('Register', function (): void {
    it('can register with valid data', function (): void {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $responseData = postJson('/api/v1/auth/register', $data)
            ->assertStatus(201)
            ->assertApiStructure(new TokenStructure())
            ->json();

        expect($responseData)
            ->access_token->not->toBeEmpty()
            ->type->toBe('Sanctum')
            ->expires_at->not->toBeEmpty()
            ->and($responseData['user'])
            ->name->toBe($data['name'])
            ->email->toBe($data['email']);
    });

    it('requires valid email format', function (): void {
        $data = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        postJson('/api/v1/auth/register', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    it('requires unique email', function (): void {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        postJson('/api/v1/auth/register', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    it('requires password confirmation', function (): void {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        postJson('/api/v1/auth/register', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    });

    it('requires matching password confirmation', function (): void {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ];

        postJson('/api/v1/auth/register', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    });
});
