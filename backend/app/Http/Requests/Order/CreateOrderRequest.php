<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
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
            'observation' => 'nullable|string',
            'total_value' => 'required|numeric',
            'paid' => 'required|boolean',
            'client_id' => 'required|exists:clients,id',
            'establishment_id' => 'required|exists:establishments,id',
            'order_product' => 'required|array',
            'order_product*.product_id' => 'required|exists:products,id',
            'order_product*.quantity' => 'required|numeric',
            'order_product*.value' => 'required|numeric',
            'order_product*.half_pizza' => 'required|boolean',
            'order_product*half_pizza_product_id' => 'nullable|exists:products,id',
            'order_product*.order_product_additional' => 'nullable|array',
            'order_product*.order_product_additional*.product_additional_id' => 'required|exists:product_additionals,id',
            'order_product*.order_product_additional*.additional_vale' => 'required|numeric',
        ];
    }
}
