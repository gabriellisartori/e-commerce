<?php

namespace App\Http\Requests\Establishment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstablishmentRequest extends FormRequest
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
            'id' => 'required|exists:establishments,id',
            'name' => 'required|string',
            'cnpj' => 'required|string|size:18',
            'phone_number' => 'required|string|size:15',
            'description' => 'nullable|string',
            'address_id' => 'required|exists:addresses,id',
            'zip_code' => 'required|string|size:9',
            'city' => 'required|string',
            'street' => 'required|string',
            'neighborhood' => 'required|string',
            'number' => 'required|integer',
            'complement' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'email' => 'required',
            'password' => 'nullable'
        ];
    }
}
