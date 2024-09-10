<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\StudentInternShip;
use App\Services\StudentInternShip\StudentInternShipService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentInternController extends Controller
{
    /**
     * @return \Inertia\Inertia;
     */
    public function getInternsForCompany()
    {
        return Inertia::render('Companies/Interns/Index', [
            'interns' => fn() => StudentInternShip::query()
                ->whereHas('company', function ($query) {
                    $query->where('company_id', Auth::user()->profile_id);
                })
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
}
