<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'string|max:255',
            'price'       => 'numeric|min:0',
            'variations'  => 'array|min:1',
            'variations.*' => 'string|max:100',
            'quantities'  => 'array|min:1',
            'quantities.*' => 'integer|min:0',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
