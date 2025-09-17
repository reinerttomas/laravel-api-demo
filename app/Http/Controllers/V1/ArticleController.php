<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Articles\CreateArticleAction;
use App\Actions\Articles\DeleteArticleAction;
use App\Actions\Articles\UpdateArticleAction;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\V1\ArticleRequest;
use App\Http\Resources\V1\ArticleResource;
use App\Models\Article;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

#[Group('Articles')]
final readonly class ArticleController
{
    use AuthorizesRequests;

    /**
     * Index
     *
     * Display a listing of the articles.
     *
     * @unauthenticated
     */
    #[QueryParameter(
        name: 'sort',
        description: 'Sort by fields. Allowed: `id`.',
        type: 'string',
        example: 'id'
    )]
    #[QueryParameter(
        name: 'include',
        description: 'Include related resources. Allowed: `author`.',
        type: 'string',
        example: 'author'
    )]
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Article::class);

        $articles = QueryBuilder::for(Article::class)
            ->allowedIncludes(['author'])
            ->allowedSorts(['id'])
            ->paginate(
                perPage: $request->perPage(),
                page: $request->page()
            );

        return ArticleResource::collection($articles);
    }

    /**
     * Show
     *
     * Display the specified article.
     *
     * @unauthenticated
     */
    #[QueryParameter(
        name: 'include',
        description: 'Include related resources. Allowed: `author`.',
        type: 'string',
        example: 'author'
    )]
    public function show(int $article): ArticleResource
    {
        $article = QueryBuilder::for(Article::class)
            ->allowedIncludes(['author'])
            ->findOrFail($article);

        $this->authorize('view', $article);

        return ArticleResource::make($article);
    }

    /**
     * Store
     *
     * Create a new article.
     */
    public function store(
        ArticleRequest $request,
        CreateArticleAction $createArticleAction,
    ): ArticleResource {
        return ArticleResource::make(
            $createArticleAction->handle($request->validated())
        );
    }

    /**
     * Update
     *
     * Update the specified article.
     */
    public function update(
        Article $article,
        ArticleRequest $request,
        UpdateArticleAction $updateArticleAction,
    ): ArticleResource {
        $this->authorize('update', $article);

        return ArticleResource::make(
            $updateArticleAction->handle($article, $request->validated())
        );
    }

    /**
     * Destroy
     *
     * Remove the specified article.
     */
    public function destroy(
        Article $article,
        DeleteArticleAction $deleteArticleAction,
    ): Response {
        $this->authorize('delete', $article);

        $deleteArticleAction->handle($article);

        return response()->noContent();
    }
}
