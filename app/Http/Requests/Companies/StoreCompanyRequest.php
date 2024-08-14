<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\InteractsWithFailedValidationAttempt;
use Illuminate\Validation\Rules\Password;

class StoreCompanyRequest extends FormRequest
{
    use InteractsWithFailedValidationAttempt;

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
            'first_name' => ['required', 'max:255', 'string'],
            'company_name' => ['required', 'max:255', 'string'],
            'last_name' => ['required', 'max:255', 'string'],
            'password' => ['required', 'string', Password::default(), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'email' => ['required', 'email:filter_unicode,dns', 'max:255', 'unique:users,id'],
            'phone_number' => ['nullable', 'regex:/^\d{8}$/'],
            'website' => ['nullable', 'max:255', 'url'],
            'service' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }
}
