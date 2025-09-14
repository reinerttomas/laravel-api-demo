<?php

declare(strict_types=1);

namespace Tests\Structure;

final readonly class CollectionStructure extends Structure
{
    public function __construct(
        private Structure $resource,
    ) {}

    public static function of(Structure $resource): self
    {
        return new self($resource);
    }

    public function toArray(): array
    {
        return [
            '*' => $this->resource->toArray(),
        ];
    }
}
