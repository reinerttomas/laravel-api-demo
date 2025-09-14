<?php

declare(strict_types=1);

namespace Tests\Support\Macros;

use Closure;
use Illuminate\Testing\TestResponse;
use Tests\Structure\PaginatedStructure;
use Tests\Structure\Structure;

/**
 * @method TestResponse<\Illuminate\Http\JsonResponse> assertApiStructure(Structure $structure)
 */
final readonly class AssertPaginatedApiStructure
{
    /**
     * @return Closure(Structure): TestResponse<\Illuminate\Http\JsonResponse>
     */
    public function __invoke(): Closure
    {
        return fn (Structure $resource): TestResponse => $this->assertApiStructure(PaginatedStructure::of($resource));
    }
}
