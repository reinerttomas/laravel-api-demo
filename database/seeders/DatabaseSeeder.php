<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()->count(100)->create();

        User::factory()
            ->count(10)
            ->recycle(Article::factory()->count(100)->create())
            ->create();
    }
}
