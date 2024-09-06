<?php

namespace App\Http\Controllers\Students;

use App\Enums\PartnershipStatus;
use App\Http\Controllers\Controller;
use App\Models\Candidacy;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardStudentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Inertia\Inertia;
     */
    public function __invoke()
    {
        return Inertia::render('Students/Dashboard', [
            'filters' => fn () => request()->all('search', 'candidacy_status'),
            'status' => fn () => PartnershipStatus::toMultiselectFormat(),
            'candidacies' => fn() => Candidacy::query()
                ->where('student_id', Auth::user()->profile_id)
                ->with(['offer', 'offer.company', 'offer.internShip'])
                ->filter(request()->only('search', 'candidacy_status'))
                ->orderBy(Candidacy::UPDATED_AT)
                ->paginate(config('custom.records_per_page'))
                ->withQueryString(),
        ]);
    }
}
