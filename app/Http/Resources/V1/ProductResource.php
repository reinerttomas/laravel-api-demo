<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\Common\MoneyResource;
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
            'price' => MoneyResource::make($this->price),

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
