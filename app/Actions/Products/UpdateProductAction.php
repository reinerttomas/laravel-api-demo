<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class UpdateProductAction
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function handle(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data): Product {
            $product->update($data);

            return $product;
        });
    }
}
