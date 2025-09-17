<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Models\Article;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ArticleRequest extends FormRequest
{
    private ?Article $article = null;

    public function authorize(Gate $gate): bool
    {
        return $this->article instanceof Article
            ? $gate->allows('update', $this->article)
            : $gate->allows('create', Article::class);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:200',
            ],
            'content' => [
                'required',
                'string',
                'max:1000',
            ],
            'author_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id'),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->route('article') instanceof Article) {
            $this->article = $this->route('article');
        }
    }
}
