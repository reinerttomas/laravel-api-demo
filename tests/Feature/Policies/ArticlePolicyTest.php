<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\User;
use App\Policies\ArticlePolicy;

describe('ArticlePolicy', function (): void {
    beforeEach(function (): void {
        $this->policy = new ArticlePolicy();
    });

    describe('viewAny', function (): void {
        it('allows authenticated users to view articles', function (): void {
            $user = User::factory()->create();

            expect($this->policy->viewAny($user))->toBeTrue();
        });

        it('allows guest users to view articles', function (): void {
            expect($this->policy->viewAny(null))->toBeTrue();
        });
    });

    describe('view', function (): void {
        it('allows authenticated users to view a specific article', function (): void {
            $user = User::factory()->create();
            $article = Article::factory()->create();

            expect($this->policy->view($user, $article))->toBeTrue();
        });

        it('allows guest users to view a specific article', function (): void {
            $article = Article::factory()->create();

            expect($this->policy->view(null, $article))->toBeTrue();
        });
    });

    describe('create', function (): void {
        it('allows authenticated users to create articles', function (): void {
            $user = User::factory()->create();

            expect($this->policy->create($user))->toBeTrue();
        });
    });

    describe('update', function (): void {
        it('allows the author to update their own article', function (): void {
            $author = User::factory()->create();
            $article = Article::factory()->author($author)->create();

            expect($this->policy->update($author, $article))->toBeTrue();
        });

        it('denies other users from updating an article', function (): void {
            $author = User::factory()->create();
            $otherUser = User::factory()->create();
            $article = Article::factory()->author($author)->create();

            expect($this->policy->update($otherUser, $article))->toBeFalse();
        });
    });

    describe('delete', function (): void {
        it('allows the author to delete their own article', function (): void {
            $author = User::factory()->create();
            $article = Article::factory()->author($author)->create();

            expect($this->policy->delete($author, $article))->toBeTrue();
        });

        it('denies other users from deleting an article', function (): void {
            $author = User::factory()->create();
            $otherUser = User::factory()->create();
            $article = Article::factory()->author($author)->create();

            expect($this->policy->delete($otherUser, $article))->toBeFalse();
        });
    });
});
