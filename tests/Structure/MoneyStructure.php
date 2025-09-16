<?php

declare(strict_types=1);

namespace Tests\Structure;

final readonly class MoneyStructure extends Structure
{
    public function toArray(): array
    {
        return [
            'amount',
            'currency',
            'formatted',
        ];
    }
}
