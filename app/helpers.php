<?php

declare(strict_types=1);

if (! function_exists('array_when')) {
    /**
     * @param  bool|Closure(): bool  $condition
     * @param  array<string, mixed>  $when
     * @param  array<string, mixed>  $otherwise
     *
     * @return array<string, mixed>
     */
    function array_when(bool|Closure $condition, array $when, array $otherwise = []): array
    {
        return $condition ? $when : $otherwise;
    }
}
