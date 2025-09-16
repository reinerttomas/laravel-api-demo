<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\IndexRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

#[Group('Products')]
final readonly class ProductController
{
    /**
     * Index
     *
     * Display a listing of the products.
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $products = QueryBuilder::for(Product::class)
            ->paginate(perPage: $request->perPage(), page: $request->page());

        return ProductResource::collection($products);
    }

    /**
     * Show
     *
     * Display the specified product.
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
