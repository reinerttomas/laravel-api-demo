<?php

declare(strict_types=1);

namespace Tests\Structure\V1;

use Tests\Structure\Structure;

use function array_when;

final readonly class ArticleStructure extends Structure
{
    public function __construct(
        private bool $author = false,
    ) {}

    public function toArray(): array
    {
        return [
            'id',
            'author_id',
            'title',
            'content',
            'created_at',
            'updated_at',

            ...array_when($this->author, ['author' => new UserStructure]),
        ];
    }
}
