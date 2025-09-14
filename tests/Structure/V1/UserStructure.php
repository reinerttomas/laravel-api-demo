<?php

declare(strict_types=1);

namespace Tests\Structure\V1;

use Tests\Structure\Structure;

final readonly class UserStructure extends Structure
{
    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ];
    }
}
