<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\User;
use Tests\Structure\V1\ArticleStructure;
use Tests\Support\Http\QueryBuilder;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

describe('Index', function (): void {
    it('returns a paginated list of articles', function (): void {
        Article::factory()->count(3)->create();

        getJson('/api/v1/articles')
            ->assertStatus(200)
            ->assertPaginatedApiCount(3)
            ->assertPaginatedApiStructure(new ArticleStructure());
    });

    it('returns a paginated list of articles with include author', function (): void {
        Article::factory()->count(3)->create();

        $query = QueryBuilder::make()->include('author');

        getJson("/api/v1/articles?$query")
            ->assertStatus(200)
            ->assertPaginatedApiCount(3)
            ->assertPaginatedApiStructure(new ArticleStructure(author: true));
    });
});

describe('Show', function (): void {
    it('returns a specific article', function (): void {
        $article = Article::factory()->create();

        getJson("/api/v1/articles/$article->id")
            ->assertStatus(200)
            ->assertApiStructure(new ArticleStructure());
    });

    it('returns a specific article with include author', function (): void {
        $article = Article::factory()->create();

        $query = QueryBuilder::make()->include('author');

        getJson("/api/v1/articles/$article->id?$query")
            ->assertStatus(200)
            ->assertApiStructure(new ArticleStructure(author: true));
    });
});

describe('Create', function (): void {
    it('creates a new article with valid data', function (): void {
        $author = User::factory()->create();

        actingAs($author);

        $data = [
            'title' => fake()->text(200),
            'content' => fake()->text(1000),
            'author_id' => $author->id,
        ];

        $responseData = postJson('/api/v1/articles', $data)
            ->assertStatus(201)
            ->assertApiStructure(new ArticleStructure)
            ->json();

        expect($responseData)
            ->title->toBe($data['title'])
            ->content->toBe($data['content'])
            ->author_id->toBe($data['author_id']);
    });

    it('validates required fields', function (): void {
        $user = User::factory()->create();

        actingAs($user);

        postJson('/api/v1/articles')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content', 'author_id']);
    });
});

describe('Update', function (): void {
    it('updates an existing article with valid data', function (): void {
        $author = User::factory()->create();

        $article = Article::factory()
            ->author($author)
            ->create();

        actingAs($author);

        $data = [
            'title' => fake()->text(200),
            'content' => fake()->text(1000),
            'author_id' => $author->id,
        ];

        $responseData = putJson("/api/v1/articles/$article->id", $data)
            ->assertStatus(200)
            ->assertApiStructure(new ArticleStructure)
            ->json();

        expect($responseData)
            ->title->toBe($data['title'])
            ->content->toBe($data['content'])
            ->author_id->toBe($data['author_id']);
    });

    it('validates required fields on update', function (): void {
        $author = User::factory()->create();

        $article = Article::factory()
            ->author($author)
            ->create();

        actingAs($author);

        putJson("/api/v1/articles/$article->id", [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content', 'author_id']);
    });
});

describe('Destroy', function (): void {
    it('deletes an existing article', function (): void {
        $author = User::factory()->create();

        $article = Article::factory()
            ->author($author)
            ->create();

        actingAs($author);

        deleteJson("/api/v1/articles/$article->id")
            ->assertStatus(204);

        getJson("/api/v1/articles/$article->id")
            ->assertStatus(404);
    });
});
