<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

final readonly class ArticlePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Article $article): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Article $article): bool
    {
        return $this->canManage($user, $article);
    }

    public function delete(User $user, Article $article): bool
    {
        return $this->canManage($user, $article);
    }

    /**
     * User can manage the article if:
     *
     * - User is the author of the article
     */
    private function canManage(User $user, Article $article): bool
    {
        return $user->id === $article->author_id;
    }
}
