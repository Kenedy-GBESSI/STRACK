<?php

namespace App\Http\Controllers\Students;

use App\Enums\InternshipStatus;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Student;
use App\Models\StudentInternShip;
use App\Traits\InteractsWithAlert;
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

            $this->alert("Stage démarré avec succès !");
        } else {

            $this->warningAlert("Cette offre n'est liée à aucune campagne de stage en cours. Vous pouvez contacter l'entreprise pour un entretien post plateforme !");
        }
    }
}
