<?php

namespace App\Http\Controllers\Students;

use App\Enums\InternshipStatus;
use App\Enums\StudyField;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\StoreStudentRequest;
use App\Http\Requests\Students\UpdateStudentRequest;
use App\Models\Candidacy;
use App\Models\Student;
use App\Models\StudentInternShip;
use App\Services\StudentInternShip\StudentInternShipService;
use App\Traits\InteractsWithAlert;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    use InteractsWithAlert;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Students/Index', [
            'filters' => fn() => $request->all('search', 'study_field', 'internship_status'),
            'studyFields' => fn() => StudyField::toMultiselectFormat(),
            'internshipStatus' => fn() => InternshipStatus::toMultiselectFormat(),
            'students' => fn() => Student::query()
                ->with('user')
                ->filter(request()->only('search', 'study_field', 'internship_status'))
                ->join('users', function ($join) {
                    $join->on('students.id', '=', 'users.profile_id')
                        ->where('users.profile_type', Student::class);
                })
                ->orderBy('users.last_name', 'asc')
                ->orderBy('users.first_name', 'asc')
                ->select('students.*')
                ->paginate(config('custom.records_per_page'))
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Students/Create', [
            'studyFields' => fn() => StudyField::cases(),
            'internshipStatus' => fn() => InternshipStatus::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());

        $this->alert('L\'étudiant est créé avec succès !');

        return to_route('students.edit', $student);
    }

    /**
     * Show the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show(Student $student)
    {
        $internShip = $student->internShip;
        $fileData = is_null($internShip) ? [] :  [(new StudentInternShipService)->getFileData($internShip)];

        return Inertia::render('Students/Show', [

            'student' => array_merge($student->load('user')->toArray(), [
                'internShip' => [
                    'data' => $internShip?->toArray(),
                    'fileData' => $fileData
                ]
            ]),

            'candidacies' => Candidacy::query()
                ->where('student_id', $student->id)
                ->with(['offer', 'offer.company', 'offer.internShip'])
                ->filter(request()->only('search', 'candidacy_status'))
                ->orderBy(Candidacy::UPDATED_AT)
                ->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function edit(Student $student)
    {
        return Inertia::render('Students/Edit', [
            'student' => $student,
            'studyFields' => fn() => StudyField::cases(),
            'internshipStatus' => fn() => InternshipStatus::cases(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        $this->alert('L\'étudiant est modifié avec succès !');

        return back();
    }

    public function gradeStudent(Request $request, StudentInternShip $studentInternShip)
    {
        $validatedData = $request->validate([
            'note' => 'required|numeric|min:5|max:17',
        ]);

        $studentInternShip->update([
            'final_note' => $validatedData['note']
        ]);

        $this->alert('La note de l\'étudiant est modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Student $student)
    {
        $student->delete();

        $this->alert('L\'étudiant est supprimé avec succès !');

        return back();
    }
}
