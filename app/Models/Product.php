<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Currency;
use Cknow\Money\Casts\MoneyIntegerCast;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read \Cknow\Money\Money $price
 * @property-read Currency $currency
 * @property-read \Carbon\CarbonImmutable $created_at
 * @property-read \Carbon\CarbonImmutable $updated_at
 */
#[UseFactory(ProductFactory::class)]
final class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'price' => MoneyIntegerCast::class . ':currency',
            'currency' => Currency::class,
        ];
    }
}
