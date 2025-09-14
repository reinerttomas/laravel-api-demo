<?php

declare(strict_types=1);

namespace Tests\Support\Macros;

use Closure;
use Illuminate\Testing\TestResponse;
use Tests\Structure\Structure;

/**
 * @mixin TestResponse<\Illuminate\Http\JsonResponse>
 */
final readonly class AssertApiStructure
{
    /**
     * @return Closure(Structure|array<array-key, mixed>|null, array<array-key, mixed>|null): TestResponse<\Illuminate\Http\JsonResponse>
     */
    public function __invoke(): Closure
    {
        return function (Structure|array $structure, ?array $responseData = null): TestResponse {
            // Process array and handle merging
            $processArray = function (array $data, callable $convert): array {
                $result = [];

                foreach ($data as $key => $value) {
                    if (is_int($key) && $value instanceof Structure) {
                        // Merge Arrayable objects without keys
                        $result = [...$result, ...$convert($value)];
                    } else {
                        // Keep keyed values or process recursively
                        $result[$key] = $convert($value);
                    }
                }

                return $result;
            };

            // Convert Arrayable objects to arrays and handle merging
            $convertArrayable = function (mixed $data) use (&$convertArrayable, &$processArray): mixed {
                return match (true) {
                    $data instanceof Structure => $convertArrayable($data->toArray()),
                    is_array($data) => $processArray($data, $convertArrayable),
                    default => $data
                };
            };

            return $this->assertJsonStructure($convertArrayable($structure), $responseData);
        };
    }
}
