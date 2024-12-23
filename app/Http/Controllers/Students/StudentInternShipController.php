<?php

namespace App\Http\Controllers\Students;

use App\Data\File\FileData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Candidacies\ToApplyOfferRequest;
use App\Jobs\SendEmailForCompany;
use App\Models\Candidacy;
use App\Models\Offer;
use App\Models\Student;
use App\Models\StudentInternShip;
use App\Services\StudentInternShip\StudentInternShipService;
use App\Traits\InteractsWithAlert;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentInternShipController extends Controller
{
    use InteractsWithAlert;

    public function startInternShip(Student $student, Offer $offer)
    {

        $internShip = $offer->internShip;

        if (! is_null($internShip)) {

            $startDate = Carbon::parse($internShip->start_date);
            $endDate = Carbon::parse($internShip->end_date);
            $durationOfInternShip = $startDate->diffInDays($endDate);

            StudentInternShip::create([
                'student_id' => $student->id,
                'intern_ship_id' => $internShip->id,
                'company_id' => $offer->company?->id,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addDays($durationOfInternShip)->format('Y-m-d')
            ]);

            // $candidacies = Candidacy::query()
            //     ->where('student_id', Auth::user()->profile_id)
            //     ->with(['offer.company.user'])
            //     ->orderBy(Candidacy::UPDATED_AT)
            //     ->get();

            // $company_emails = $candidacies
            //     ->map(function ($candidacy) {
            //         return $candidacy->offer?->company?->user?->email ?? null;
            //     })
            //     ->filter()
            //     ->unique();

            // $emails_array = $company_emails->toArray();

            // SendEmailForCompany::dispatch($student, $emails_array);

            $this->alert("Stage démarré avec succès !");
        } else {

            $this->warningAlert("Cette offre n'est liée à aucune campagne de stage en cours. Vous pouvez contacter l'entreprise pour un entretien post plateforme !");
        }
    }

    public function saveRapportFile(ToApplyOfferRequest $request, StudentInternShip $studentInternShip)
    {
        $request->whenFilled('fileData', function (array $fileData) use ($studentInternShip) {
            (new StudentInternShipService)->saveFile($studentInternShip, FileData::from($fileData));
        });

        $this->alert('Le rapport a bien été envoyé à votre entreprise de stage!');

        return back();
    }
}
