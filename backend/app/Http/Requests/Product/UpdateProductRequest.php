<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:products,id',
            'name' => 'required|string',
            'image' => 'required',
            'value' => 'required',
            'active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'promotion' => 'nullable|array',
            'promotion.*.id' => 'nullable|exists:promotions,id',
            'promotion.*.value' => 'nullable',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'additional' => 'nullable|array',
            'additional.*.id' => 'required|exists:ingredients,id',
            'additional.*.value' => 'nullable'
        ];
    }
}
