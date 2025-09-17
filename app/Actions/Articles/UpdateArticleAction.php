<?php

declare(strict_types=1);

namespace App\Actions\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class UpdateArticleAction
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws Throwable
     */
    public function handle(Article $article, array $data): Article
    {
        return DB::transaction(function () use ($article, $data): Article {
            $article->update($data);

            return $article;
        });
    }
}
