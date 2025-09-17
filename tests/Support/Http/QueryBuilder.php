<?php

declare(strict_types=1);

namespace Tests\Support\Http;

use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * @implements Arrayable<string, mixed>
 */
final class QueryBuilder implements Arrayable, Stringable
{
    /**
     * @var array<string, mixed>
     */
    private array $filters = [];

    /**
     * @var list<string>
     */
    private array $includes = [];

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function make(): self
    {
        return new self();
    }

    public function filter(string $key, mixed $value): self
    {
        $this->filters[$key] = $value;

        return $this;
    }

    public function include(string ...$includes): self
    {
        $this->includes = array_merge($this->includes, $includes);

        return $this;
    }

    public function toArray(): array
    {
        $query = [];

        if ($this->filters !== []) {
            $query['filter'] = $this->filters;
        }

        if ($this->includes !== []) {
            $query['include'] = implode(',', $this->includes);
        }

        return $query;
    }

    public function toString(): string
    {
        return http_build_query($this->toArray());
    }
}
