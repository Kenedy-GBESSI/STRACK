<?php

namespace App\Http\Controllers\Companies;

use App\Data\Company\CompanyData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Companies\StoreCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CompanyRegisterController extends Controller
{
      /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function companyRegisterView()
    {
        return Inertia::render('Auth/CompanyRegister');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function companyRegister(StoreCompanyRequest $request)
    {
        $company = Company::create(CompanyData::from($request->validated())->toArray());

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

        return to_route('home');
    }
}
