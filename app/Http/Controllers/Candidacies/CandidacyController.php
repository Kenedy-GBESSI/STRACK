<?php

namespace App\Http\Controllers\Candidacies;

use App\Data\File\FileData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Candidacies\ToApplyOfferRequest;
use App\Models\Candidacy;
use App\Models\Offer;
use App\Models\Student;
use App\Services\Candidacy\CandidacyService;
use App\Traits\InteractsWithAlert;
use Illuminate\Http\Request;

class CandidacyController extends Controller
{
    use InteractsWithAlert;

    /**
     * To apply an offer by student 
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toApplyOffer(ToApplyOfferRequest $request, Student $student, Offer $offer) {

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
}
