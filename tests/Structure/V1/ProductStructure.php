<?php

declare(strict_types=1);

namespace Tests\Structure\V1;

use Tests\Structure\Structure;

final readonly class ProductStructure extends Structure
{
    /**
     * @return list<string>
     */
    public function toArray(): array
    {
        return [
            'id',
            'name',
            'price',
            'currency',
            'created_at',
            'updated_at',
        ];
    }
}
