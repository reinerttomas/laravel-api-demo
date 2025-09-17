<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
final class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => fn (): User => User::factory()->create(),
            'title' => fake()->text(200),
            'content' => fake()->text(1000),
        ];
    }

    public function author(User $author): self
    {
        return $this->for($author, 'author');
    }
}
