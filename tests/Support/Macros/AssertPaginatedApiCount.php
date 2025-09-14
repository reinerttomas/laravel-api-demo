<?php

declare(strict_types=1);

namespace Tests\Support\Macros;

use Closure;
use Illuminate\Testing\TestResponse;

/**
 * @mixin TestResponse<\Illuminate\Http\JsonResponse>
 */
final readonly class AssertPaginatedApiCount
{
    /**
     * @return Closure(int): TestResponse<\Illuminate\Http\JsonResponse>
     */
    public function __invoke(): Closure
    {
        return fn (int $count): TestResponse => $this->assertJsonCount($count, 'data');
    }
}
