<?php

namespace App\Http\Requests;

use App\Http\Dto\UserDto;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
        return [
            'username' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(\d{1,3}[- ]?)?\d{10}$/', 'unique:users,phone'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'phone' => preg_replace('/[^0-9]/', '', $this->phone),
        ]);
    }

    /**
     * @return UserDto
     */
    public function getDto(): UserDto
    {
        return new UserDto($this->username, (int) $this->phone);
    }
}
