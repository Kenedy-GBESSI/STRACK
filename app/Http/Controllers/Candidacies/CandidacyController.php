<?php

namespace App\Http\Controllers\Candidacies;

use App\Data\File\FileData;
use App\Enums\InternshipStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Candidacies\ToApplyOfferRequest;
use App\Models\Candidacy;
use App\Models\Offer;
use App\Models\Student;
use App\Services\Candidacy\CandidacyService;
use App\Traits\InteractsWithAlert;
use App\Enums\PartnershipStatus;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CandidacyController extends Controller
{
    use InteractsWithAlert;

    /**
     * To apply an offer by student
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toApplyOffer(ToApplyOfferRequest $request, Student $student, Offer $offer)
    {

        $candidacy = Candidacy::create([
            'student_id' => $student->id,
            'offer_id' => $offer->id,
        ]);

        $request->whenFilled('fileData', function (array $fileData) use ($candidacy) {
            (new CandidacyService)->saveFile($candidacy, FileData::from($fileData));
        });

        $this->alert('Vous avez bien postulé à l\'offre !');

        return back();
    }

    /**
     * @return \Inertia\Inertia;
     */
    public function getCandidaciesForCompany()
    {
        return Inertia::render('Companies/Candidacies/Index', [
            'filters' => fn() => request()->all('search', 'candidacy_status'),
            'status' => fn() => PartnershipStatus::toMultiselectFormat(),
            'candidacies' => fn() => Candidacy::query()
                ->whereHas('offer', function ($query) {
                    $query->where('company_id', Auth::user()->profile_id);
                })
                ->with(['student', 'student.user', 'offer', 'offer.internShip'])
                ->filter(request()->only('search', 'candidacy_status'))
                ->orderBy(Candidacy::UPDATED_AT)
                ->paginate(config('custom.records_per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * @return \Inertia\Inertia;
     */
    public function showCandidacy(Candidacy $candidacy)
    {
        $fileData = (new CandidacyService)->getFileData($candidacy);

        return Inertia::render('Companies/Candidacies/Show', [
            'candidacy' => fn() => array_merge(
                $candidacy->load(['student', 'student.user', 'offer', 'offer.internShip'])->toArray(),
                [
                    'fileData' => $fileData ? [$fileData] : []
                ]
            )
        ]);
    }

    public function rejectCandidacy(Candidacy $candidacy)
    {
        $candidacy->update([
            'status' => PartnershipStatus::REJECTED_PARTNERSHIP->value
        ]);

        $this->alert("La candidature de {$candidacy->student?->user?->full_name} est rejectée avec succès !");
    }

    public function validateCandidacy(Candidacy $candidacy)
    {
        $candidacy->update([
            'status' => PartnershipStatus::VALIDATED_PARTNERSHIP->value
        ]);

        $student = $candidacy->student;

        if( $student->internship_status === InternshipStatus::ON_INTERNSHIP) {

            $this->warningAlert('Le candidat est déjà en stage mais il pourra récevoir votre réponse et vous écrira !');

        } else {

            $this->alert("La candidature de {$candidacy->student?->user?->full_name} est validée avec succès !");

        }
    }
}
