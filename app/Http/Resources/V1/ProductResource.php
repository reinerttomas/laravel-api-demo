<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
final class ProductResource extends JsonResource
{
    public static $wrap;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * @var int
             */
            'id' => $this->id,

            'name' => $this->name,

            /**
             * @var int
             */
            'price' => $this->price,

            /**
             * @var \App\Enums\Currency
             */
            'currency' => $this->currency,

            /**
             * @var \Carbon\CarbonImmutable
             */
            'created_at' => $this->created_at,

            /**
             * @var \Carbon\CarbonImmutable
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
