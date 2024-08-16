<?php

namespace App\Http\Controllers\Companies;

use App\Enums\PartnershipStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Traits\InteractsWithAlert;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    use InteractsWithAlert;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Companies/Index', [
            'filters' => fn () => $request->all('search', 'partnership_status'),
            'partnerShipStatus' => fn () => PartnershipStatus::toMultiselectFormat(),
            'companies' => fn () => Company::query()
            ->with('user')
            ->filter(request()->only('search', 'partnership_status'))
            ->join('users', function ($join) {
                $join->on('companies.id', '=', 'users.profile_id')
                    ->where('users.profile_type', Company::class);
            })
            ->orderBy('users.last_name', 'asc')
            ->orderBy('users.first_name', 'asc')
            ->select('companies.*')
            ->paginate(config('custom.records_per_page'))
            ->withQueryString()
        ]);
    }
}
