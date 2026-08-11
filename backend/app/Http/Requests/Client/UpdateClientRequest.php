<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'id' => 'required|exists:clients,id',
            'name' => 'required|string',
            'cpf' => 'required|string|size:14',
            'phone_number' => 'required|string|size:15',
            'date_birth' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'email' => 'required',
            'password' => 'nullable'
        ];
    }
}
