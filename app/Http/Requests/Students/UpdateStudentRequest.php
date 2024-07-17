<?php

namespace App\Http\Requests\Students;

use App\Enums\InternshipStatus;
use App\Enums\StudyField;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\InteractsWithFailedValidationAttempt;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
            'matriculation_number' => [
                'required',
                'max:255',
                'string',
                Rule::unique('students', 'matriculation_number')->ignore($this->route('student'))
            ],
            'first_name' => ['required', 'max:255', 'string'],
            'last_name' => ['required', 'max:255', 'string'],
            'study_field' => ['required', new Enum(StudyField::class), 'max:255', 'string'],
            'internship_status' => ['required','string', 'max:255', new Enum(InternshipStatus::class)],
            'email' => [
                'required',
                'max:50',
                'email:filter_unicode,dns',
                 Rule::unique('students', 'email')->ignore($this->route('student'))
            ],
        ];
    }
}
