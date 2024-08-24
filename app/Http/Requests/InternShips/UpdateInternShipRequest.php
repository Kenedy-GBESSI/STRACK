<?php

namespace App\Http\Requests\InternShips;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\InteractsWithFailedValidationAttempt;

class UpdateInternShipRequest extends FormRequest
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
            'title' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],

            // Associated's file
            'fileData' => ['nullable', 'array', 'max:1'],
            'fileData.*.server_id' => ['required', 'string'],
            'fileData.*.id' => ['nullable', 'string'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->whenFilled('fileData', function ($fileData) {
            /** @var array<int, array<string, mixed>> $fileData */
            $fileDataCollection = collect($fileData);
            if ($fileDataCollection->isNotEmpty() || $fileDataCollection->count() === 1) {
                $this->merge(['fileData' => $fileDataCollection->first()]);
            } else {
                $this->merge(['fileData' => null]);
            }
        });
    }
}
