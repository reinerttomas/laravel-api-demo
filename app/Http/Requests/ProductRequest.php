<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ProductRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'price' => [
                'required',
                Rule::numeric()->min(0),
            ],
            'currency' => [
                'required',
                Rule::enum(Currency::class),
            ],
        ];
    }
}
