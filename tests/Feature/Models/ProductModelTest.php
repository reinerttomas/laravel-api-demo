<?php

declare(strict_types=1);

use App\Enums\Currency;
use App\Models\Product;
use Cknow\Money\Money;

test('price is cast as money', function (): void {
    $product = Product::factory()->create([
        'price' => 19.99,
        'currency' => Currency::USD,
    ]);

    ray($product->price->formatByDecimal());

    expect($product->price)
        ->toBeInstanceOf(Money::class)
        ->and($product->price->getAmount())->toBe('1999')
        ->and($product->price->formatByDecimal())->toBe('19.99')
        ->and($product->price->format())->toBe('$19.99');
});

test('currency is cast as enum', function (): void {
    $product = Product::factory()->create([
        'currency' => Currency::EUR,
    ]);

    expect($product->currency)
        ->toBeInstanceOf(Currency::class)
        ->toBe(Currency::EUR);
});
