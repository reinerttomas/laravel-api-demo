<?php

declare(strict_types=1);

namespace Tests\Structure;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<array-key, mixed>
 */
abstract readonly class Structure implements Arrayable
{
    /**
     * @return array<array-key, mixed>
     */
    abstract public function toArray(): array;
}
