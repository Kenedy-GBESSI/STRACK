<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use App\Traits\InteractsWithAlert;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Services\Offers\OfferService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OfferForStudentController extends Controller
{
    use InteractsWithAlert;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function getOffersForStudent(Request $request)
    {
        return Inertia::render('Students/Offers/Index', [
            'filters' => fn() => $request->all('search'),
            'offers' => fn() => Offer::query()
                ->where(function ($query) {
                    $query->whereHas('internShip', function ($query) {
                        $currentDate = Carbon::now()->format('Y-m-d');

                        $query
                            ->where('academic_year', Auth::user()->profile->academic_year)
                            ->whereDate('end_date', '>=', $currentDate);;
                    })
                        ->orWhereDoesntHave('internShip');
                })
                ->whereDoesntHave('candidacies', function ($query) {
                    $query->where('student_id', Auth::user()->profile_id);
                })
                ->with('internShip')
                ->filter(request()->only('search'))
                ->orderBy('title', 'asc')
                ->paginate(5)
                ->withQueryString()
                ->through(function (Offer $offer) {
                    return (new OfferService)->loadForDisplay($offer);
                }),
        ]);
    }
}
