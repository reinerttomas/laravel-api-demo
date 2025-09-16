<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class IndexRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            /**
             * @default 15
             */
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],

            /**
             * @default 1
             */
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function perPage(): int
    {
        return $this->integer('per_page', 15);
    }

    public function page(): int
    {
        return $this->integer('page', 1);
    }
}
