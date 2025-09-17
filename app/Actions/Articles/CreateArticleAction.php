<?php

declare(strict_types=1);

namespace App\Actions\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class CreateArticleAction
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function handle(array $data): Article
    {
        return DB::transaction(
            fn (): Article => Article::query()->create($data)
        );
    }
}
