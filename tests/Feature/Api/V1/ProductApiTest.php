<?php

declare(strict_types=1);

use App\Enums\Currency;
use App\Models\Product;
use Tests\Structure\V1\ProductStructure;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

describe('Index', function (): void {
    it('returns a paginated list of products', function (): void {
        Product::factory()->count(3)->create();

        getJson('/api/v1/products')
            ->assertStatus(200)
            ->assertPaginatedApiCount(3)
            ->assertPaginatedApiStructure(new ProductStructure());
    });
});

describe('Show', function (): void {
    it('returns a specific product', function (): void {
        $product = Product::factory()->create();

        getJson("/api/v1/products/$product->id")
            ->assertStatus(200)
            ->assertApiStructure(new ProductStructure());
    });
});

describe('Create', function (): void {
    it('creates a new product with valid data', function (): void {
        $data = [
            'name' => fake()->text(100),
            'price' => fake()->randomFloat(2, 100, 10000),
            'currency' => fake()->randomElement(Currency::class)->value,
        ];

        $responseData = postJson('/api/v1/products', $data)
            ->assertStatus(201)
            ->assertApiStructure(new ProductStructure)
            ->json();

        expect($responseData)
            ->name->toBe($data['name'])
            ->price->amount->toBe($data['price'])
            ->price->currency->toBe($data['currency']);
    });

    it('validates required fields', function (): void {
        postJson('/api/v1/products')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'currency']);
    });
});

describe('Update', function (): void {
    it('updates an existing product with valid data', function (): void {
        $product = Product::factory()->create();

        $data = [
            'name' => fake()->text(100),
            'price' => fake()->randomFloat(2, 100, 10000),
            'currency' => fake()->randomElement(Currency::class)->value,
        ];

        $responseData = putJson("/api/v1/products/$product->id", $data)
            ->assertStatus(200)
            ->assertApiStructure(new ProductStructure)
            ->assertApiStructure(new ProductStructure)
            ->json();

        expect($responseData)
            ->name->toBe($data['name'])
            ->price->amount->toBe($data['price'])
            ->price->currency->toBe($data['currency']);
    });

    it('validates required fields on update', function (): void {
        $product = Product::factory()->create();

        putJson("/api/v1/products/$product->id", [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'currency']);
    });
});

describe('Destroy', function (): void {
    it('deletes an existing product', function (): void {
        $product = Product::factory()->create();

        deleteJson("/api/v1/products/$product->id")
            ->assertStatus(204);

        getJson("/api/v1/products/$product->id")
            ->assertStatus(404);
    });
});
