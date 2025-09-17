<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Products\CreateProductAction;
use App\Actions\Products\DeleteProductAction;
use App\Actions\Products\UpdateProductAction;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\V1\ProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
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
        return ProductResource::make($product);
    }

    /**
     * Store
     *
     * Create a new product.
     */
    public function store(
        ProductRequest $request,
        CreateProductAction $createProductAction,
    ): ProductResource {
        return ProductResource::make(
            $createProductAction->handle($request->validated())
        );
    }

    /**
     * Update
     *
     * Update the specified product.
     */
    public function update(
        Product $product,
        ProductRequest $request,
        UpdateProductAction $updateProductAction,
    ): ProductResource {
        return ProductResource::make(
            $updateProductAction->handle($product, $request->validated())
        );
    }

    /**
     * Destroy
     *
     * Remove the specified product.
     */
    public function destroy(
        Product $product,
        DeleteProductAction $deleteProductAction,
    ): Response {
        $deleteProductAction->handle($product);

        return response()->noContent();
    }
}
