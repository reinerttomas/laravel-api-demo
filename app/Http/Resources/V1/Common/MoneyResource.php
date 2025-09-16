<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Cknow\Money\Money
 */
final class MoneyResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * @var float
             */
            'amount' => (float) $this->formatByDecimal(),

            /**
             * @var \App\Enums\Currency
             */
            'currency' => $this->getCurrency()->getCode(),
            'formatted' => $this->format(),
        ];
    }
}
