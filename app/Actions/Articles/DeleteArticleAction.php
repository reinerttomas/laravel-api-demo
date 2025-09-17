<?php

declare(strict_types=1);

namespace App\Actions\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class DeleteArticleAction
{
    /**
     * @throws Throwable
     */
    public function handle(Article $article): void
    {
        DB::transaction(function () use ($article): void {
            $article->delete();
        });
    }
}
