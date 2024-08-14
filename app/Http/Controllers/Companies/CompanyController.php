<?php

namespace App\Http\Controllers\Companies;

use App\Data\Company\CompanyData;
use App\Enums\PartnershipStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Companies\StoreCompanyRequest;
use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use App\Traits\InteractsWithAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'filters' => fn () => $request->all('search'),
            'partnerShipStatus' => fn () => PartnershipStatus::toMultiselectFormat(),
            'companies' => fn () => Company::query()
            ->with('user')
            ->filter(request()->only('search'))
            ->join('users', function ($join) {
                $join->on('students.id', '=', 'users.profile_id')
                    ->where('users.profile_type', Company::class);
            })
            ->orderBy('users.last_name', 'asc')
            ->orderBy('users.first_name', 'asc')
            ->select('companies.*')
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
        return Inertia::render('Companies/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Student::create(CompanyData::from($request->validated())->toArray());

        $user = User::create([
            'last_name' => $request->first_name,
            'first_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile_type' => Company::class,
            'profile_id' => $company->id,
        ]);

        if ($user) {

            Auth::login($user);
        }

        return to_route('dashboard');
    }
}
