<?php

declare(strict_types=1);

namespace App\Services\Statistics;

use App\Models\Company;
use App\Models\Offer;
use App\Models\Student;
use App\Models\StudentInternShip;
use Illuminate\Support\Facades\Auth;

/**
 * Class StatisticService
 */
class StatisticService
{

    public function getInstituteStatistics()
    {

        $onInternshipCount = Student::whereHas('studentInternShips', function ($query) {
            $query->whereDate('end_date', '>=', now());
        })->count();

        $finishedInternshipCount = Student::whereHas('studentInternShips', function ($query) {
            $query->whereDate('end_date', '<', now());
        })->count();

        $noInternshipCount = Student::doesntHave('studentInternShips')->count();

        $expiredOfferCount = Offer::whereHas('internShip', function ($query) {
            $query->whereDate('end_date', '<', now());
        })->count();

        $activeOfferCount = Offer::whereHas('internShip', function ($query) {
            $query->whereDate('end_date', '>=', now());
        })->count();

        return [
            'all_students' => Student::count(),
            'students_in_intern_ship' => $onInternshipCount,
            'students_finished_intern_ship' => $finishedInternshipCount,
            'students_not_in_intern_ship' => $noInternshipCount,
            'all_offers' => Offer::count(),
            'expired_offers' => $expiredOfferCount,
            'active_offers' =>  $activeOfferCount,
            'all_companies' => Company::count(),
        ];
    }

    public function getCompanyStatistics()
    {

        $expiredOfferCount = Offer::query()
            ->where('company_id', Auth::user()->profile_id)
            ->whereHas('internShip', function ($query) {
                $query->whereDate('end_date', '<', now());
            })->count();

        $activeOfferCount = Offer::query()
            ->where('company_id', Auth::user()->profile_id)
            ->whereHas('internShip', function ($query) {
                $query->whereDate('end_date', '>=', now());
            })->count();

        return [
            'all_interns' => StudentInternShip::query()
                ->where('company_id', Auth::user()->profile_id)
                ->count(),
            'intern_finished_intern_ship' => StudentInternShip::query()
                ->where('company_id', Auth::user()->profile_id)
                ->whereHas('student.studentInternShips', function ($query) {
                    $query->whereDate('end_date', '<', now());
                })
                ->count(),
            'all_offers' => Offer::query()
                ->where('company_id', Auth::user()->profile_id)
                ->count(),
            'expired_offers' => $expiredOfferCount,
            'active_offers' =>  $activeOfferCount,
        ];
    }
}
