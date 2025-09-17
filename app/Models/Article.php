<?php

declare(strict_types=1);

namespace App\Models;

use App\Policies\ArticlePolicy;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $author_id
 * @property-read string $title
 * @property-read string $content
 * @property-read \Carbon\CarbonImmutable $created_at
 * @property-read \Carbon\CarbonImmutable $updated_at
 * @property-read User $author
 */
#[UseFactory(ArticleFactory::class)]
#[UsePolicy(ArticlePolicy::class)]
final class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'content',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
