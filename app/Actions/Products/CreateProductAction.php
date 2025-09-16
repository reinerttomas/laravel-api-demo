<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class CreateProductAction
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function handle(array $data): Product
    {
        return DB::transaction(
            fn (): Product => Product::query()->create($data)
        );
    }
}
