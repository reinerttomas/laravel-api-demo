<?php

declare(strict_types=1);

namespace Tests\Structure;

final readonly class PaginatedStructure extends Structure
{
    public function __construct(
        private Structure $collection,
    ) {}

    public static function of(Structure $resource): self
    {
        return new self(new CollectionStructure($resource));
    }

    public function toArray(): array
    {
        return [
            'data' => $this->collection->toArray(),
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ];
    }
}
