<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        
        if ($this->isMethod('POST')) {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'cpf' => 'nullable|string|unique:users,cpf',
            ];
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $this->route('id'),
                'cpf' => 'nullable|string|unique:users,cpf,' . $this->route('id'),
            ];
        }

        return $rules;
    }
}
