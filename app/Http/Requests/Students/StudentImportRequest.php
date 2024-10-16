<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class StudentImportRequest extends FormRequest
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
            'importData' => ['required', 'array', 'min:1'],
            'importData.*.server_id' => ['required', 'string'],
            'importData.*.id' => ['nullable', 'string'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->whenFilled('importData', function ($importData) {
            /** @var array<int, array<string, mixed>> $importData */
            $importDataCollection = collect($importData);
            if ($importDataCollection->isNotEmpty() || $importDataCollection->count() === 1) {
                $this->merge(['importData' => $importDataCollection->first()]);
            } else {
                $this->merge(['importData' => null]);
            }
        });
    }
}
