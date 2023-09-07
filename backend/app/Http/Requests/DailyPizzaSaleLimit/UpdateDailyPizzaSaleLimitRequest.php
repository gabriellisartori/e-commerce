<?php

namespace App\Http\Requests\DailyPizzaSaleLimit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyPizzaSaleLimitRequest extends FormRequest
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
            'id' => 'required|exists:daily_pizza_sale_limits,id',
            'quantity' => 'required|integer',
            'date' => 'required|date',
            'starts_at' => 'required',
            'end_at' => 'required'
        ];
    }
}
