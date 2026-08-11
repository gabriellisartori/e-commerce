<?php

namespace App\Http\Requests\BusinessHour;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessHourRequest extends FormRequest
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
            'days' => 'required|array',
            'days.*' => 'required',
            'days.*.id' => 'required|int',
            'days.*.day_week' => 'required|int|between:0,6',
            'days.*.start_at' => 'nullable',
            'days.*.end_at' => 'nullable'
        ];
    }
}
