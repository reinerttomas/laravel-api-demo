<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class DeleteProductAction
{
    /**
     * @throws Throwable
     */
    public function handle(Product $product): void
    {
        DB::transaction(function () use ($product): void {
            $product->delete();
        });
    }
}
