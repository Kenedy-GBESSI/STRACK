<?php

namespace App\Http\Controllers\Students;

use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StudentExportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        $students = Student::query()
            ->with('user')
            ->filter(request()->only('search', 'study_field', 'internship_status'))
            ->join('users', function ($join) {
                $join->on('students.id', '=', 'users.profile_id')
                    ->where('users.profile_type', Student::class);
            })
            ->orderBy('users.last_name', 'asc')
            ->orderBy('users.first_name', 'asc')
            ->select('students.*')
            ->get()
            ->map(function ($student) {
                return [
                    'matricule' => $student->matriculation_number,
                    'last_name' => $student->user?->last_name,
                    'first_name' => $student->user?->first_name,
                    'study_field' => $student->study_field,
                    'academic_year' => $student->academic_year,
                    'email' => $student->user?->email,
                    'internship_status' => $student->internship_status,
                    'internship_company' => $student->internShip?->company?->company_name,
                    'internship_promoteur' => $student->internShip?->company?->user?->full_name,
                    'internship_company_phone' => $student->internShip?->company?->phone_number,
                    'internship_company_adress' => $student->internShip?->company?->address,
                    'internship_company_note' => $student->internShip?->company_note,
                    'internship_institute_note' => $student->internShip?->final_note,
                ];
            });

        if ($students->isEmpty()) {
            return back();
        }

        return Excel::download(new StudentExport($students), 'Étudiants - ' . Carbon::now()->format('Ymd-His') . '.xlsx');
    }
}
