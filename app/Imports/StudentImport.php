<?php

namespace App\Imports;

use App\Enums\AcademicYear;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Enums\StudyField;
use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentImport implements SkipsEmptyRows, ToCollection, WithValidation, WithStartRow
{
    use Importable;

    /**
     * @param array $row
     */
    public function collection(Collection $rows)
    {
        $rows->map(function ($row) {

            $student = Student::create([
                'matriculation_number' => $row[0],
                'study_field' => $row[4],
                'academic_year' => $row[5],
            ]);

            $user =   User::create([
                'last_name' => $row[1],
                'first_name' => $row[2],
                'email' => $row[3],
                'password' => bcrypt('password'),
                'profile_type' => Student::class,
                'profile_id' => $student->id,
            ]);
        });
    }


    /**
     * @param  array<int,mixed>  $row
     * @return array<int, mixed>
     */
    public function prepareForValidation(array $row): array
    {
        if (isset($row[0])) {
            $row[0] = trim($row[0]);  // Matriculation number
        }

        if (isset($row[1])) {
            $row[1] = trim($row[1]);  // Last name
        }

        if (isset($row[2])) {
            $row[2] = trim($row[2]);  // First name
        }

        if (isset($row[3])) {
            $row[3] = trim($row[3]);  // Email
        }

        if (isset($row[4])) {
            $row[4] = trim($row[4]);  // Study field
        }

        if (isset($row[5])) {
            $row[5] = trim($row[5]);  // Academic year
        }

        return $row;
    }

    /**
     * @return array<int,mixed>
     */
    public function rules(): array
    {
        return [
            '0' => ['required', 'max:255', 'string', Rule::unique('students', 'matriculation_number')],
            '1' => 'required|string|max:255',
            '2' => 'required|string|max:255',
            '3' => ['required', 'max:50', 'email:filter_unicode,dns', Rule::unique('users', 'email')],
            '4' => ['required', new Enum(StudyField::class), 'max:255', 'string'],
            '5' => ['required', new Enum(AcademicYear::class), 'max:255', 'string']
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
}
