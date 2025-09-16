<?php

declare(strict_types=1);

use App\Models\Product;
use Tests\Structure\V1\ProductStructure;

use function Pest\Laravel\getJson;

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
