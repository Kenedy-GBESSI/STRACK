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
            ->orderBy(Company::CREATED_AT, 'desc')
            ->select('companies.*')
            ->paginate(config('custom.records_per_page'))
            ->withQueryString()
        ]);
    }

    /**
     * Show the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show(Company $company)
    {
        return Inertia::render('Companies/Show', [
            'company' => $company->load('user'),
        ]);
    }

    public function rejectCompany(Company $company)
    {
        $company->update([
            'partnership_status' => PartnershipStatus::REJECTED_PARTNERSHIP->value
        ]);

        $this->alert("L'entreprise {$company->company_name} est rejectée avec succès !");
    }

    public function validateCompany(Company $company)
    {
        $company->update([
            'partnership_status' => PartnershipStatus::VALIDATED_PARTNERSHIP->value
        ]);

        $this->alert("L'entreprise {$company->company_name} est validée avec succès !");
    }

     /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company)
    {
        $company->delete();

        $this->alert('L\'entreprise est supprimée avec succès !');

        return back();
    }
}
