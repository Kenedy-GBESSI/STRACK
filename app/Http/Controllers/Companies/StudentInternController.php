<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\StudentInternShip;
use App\Services\StudentInternShip\StudentInternShipService;
use Illuminate\Http\Request;
use App\Traits\InteractsWithAlert;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentInternController extends Controller
{
    use InteractsWithAlert;

    /**
     * @return \Inertia\Inertia;
     */
    public function getInternsForCompany()
    {
        return Inertia::render('Companies/Interns/Index', [
            'interns' => fn() => StudentInternShip::query()
                ->where('company_id', Auth::user()->profile_id)
                ->with(['student', 'student.user', 'internShip'])
                ->filter(request()->only('search', 'candidacy_status'))
                ->orderBy(StudentInternShip::UPDATED_AT)
                ->paginate(config('custom.records_per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * @return \Inertia\Inertia;
     */
    public function showIntern(StudentInternShip $studentInternShip)
    {
        $fileData = (new StudentInternShipService)->getFileData($studentInternShip);

        return Inertia::render('Companies/Interns/Show', [
            'intern' => fn() => array_merge(
                $studentInternShip->load(['student', 'student.user'])->toArray(),
                [
                    'fileData' => $fileData ? [$fileData] : []
                ]
            )
        ]);
    }

    public function gradeIntern(Request $request, StudentInternShip $studentInternShip)
    {
        $validatedData = $request->validate([
            'note' => 'required|numeric|min:5|max:17',
        ]);

        $studentInternShip->update([
            'company_note' => $validatedData['note']
        ]);

        $this->alert('La note du stagiaire est modifiée avec succès !');
    }

    public function rejectRapportFile(StudentInternShip $studentInternShip)
    {
        $studentInternShip->update([
            'is_intern_ship_valid' => false,
        ]);

        $this->alert("Le rapport du stagiaire est rejectée avec succès !");
    }

    public function validateRapportFile(StudentInternShip $studentInternShip)
    {
        $studentInternShip->update([
            'is_intern_ship_valid' => true,
        ]);

        $this->alert("Le rapport du stagiaire est validée avec succès");
    }

}
