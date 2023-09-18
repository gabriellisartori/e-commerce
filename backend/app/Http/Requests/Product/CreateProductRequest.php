<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required|string',
            'image' => 'required',
            'value' => 'required|numeric',
            'active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'promotion' => 'nullable|array',
            'promotion*.id' => 'nullable|exists:promotions,id',
            'promotion*.value' => 'nullable|numeric',
            'ingredients' => 'required|array',
            'ingredients*.id' => 'required|exists:ingredients,id',
            'additional' => 'nullable|array',
            'additional*.id' => 'required|exists:additionals,id',
            'additional*.value' => 'nullable|numeric'
        ];
    }
}
