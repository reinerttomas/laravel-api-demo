<?php

declare(strict_types=1);

namespace Tests\Feature;

use function Pest\Laravel\get;

test('the application returns a successful response', function (): void {
    get('/')->assertStatus(200);
});
