<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;

arch()->preset()->php();
arch()->preset()->laravel();
arch()->preset()->security();

arch('controllers')
    ->expect('App\Http\Controllers')
    ->toBeReadonly()
    ->toExtendNothing()
    ->not->toBeUsed();

arch('avoid mutation')
    ->expect('App')
    ->classes()
    ->toBeReadonly()
    ->ignoring([
        'App\Console',
        'App\Http',
        'App\Models',
        'App\Providers',
    ]);

arch('avoid inheritance')
    ->expect('App')
    ->classes()
    ->toExtendNothing()
    ->ignoring([
        'App\Console',
        'App\Http',
        'App\Models',
        'App\Providers',
    ]);

arch('avoid open for extension')
    ->expect('App')
    ->classes()
    ->toBeFinal();

arch('avoid abstraction')
    ->expect('App')
    ->not->toBeAbstract();

arch('factories')
    ->expect('Database\Factories')
    ->toExtend(Factory::class)
    ->toHaveMethod('definition')
    ->toOnlyBeUsedIn([
        'App\Models',
    ]);

arch('models')
    ->expect('App\Models')
    ->toHaveMethod(['casts', 'fillable'])
    ->toOnlyBeUsedIn([
        'App\Actions',
        'App\Console',
        'App\Http',
        'App\Models',
        'App\Policies',
        'App\Services',
        'App\ValueObjects',
        'Database\Factories',
        'Database\Seeders',
    ]);

arch('concerns')
    ->expect('App\Concerns')
    ->traits()
    ->toOnlyBeUsedIn([
        'App\Enums',
        'App\Models',
    ]);
