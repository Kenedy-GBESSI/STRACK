<?php

declare(strict_types=1);

namespace App\Traits;

use Carbon\Carbon;

trait WithCarbonDateTimeUtilities
{
    public function startOfThisMonth(): Carbon
    {
        return Carbon::now()->copy()->startOfMonth();
    }

    public function endOfThisMonth(): Carbon
    {
        return Carbon::now()->copy()->endOfMonth();
    }

    public function startOfTheLastMonth(): Carbon
    {
        return $this->getTheLastMonth()->startOfMonth();
    }

    public function endOfTheLastMonth(): Carbon
    {
        return $this->getTheLastMonth()->endOfMonth();
    }

    public function startOfTheNextMonth(): Carbon
    {
        return $this->getTheNextMonth()->startOfMonth();
    }

    public function endOfTheNextMonth(): Carbon
    {
        return $this->getTheNextMonth()->endOfMonth();
    }

    public function startOfTheLastMonthOfTheLastYear(): Carbon
    {
        return $this->getLastMonthOfTheLastYear()->startOfMonth();
    }

    public function endOfTheLastMonthOfTheLastYear(): Carbon
    {
        return $this->getLastMonthOfTheLastYear()->endOfMonth();
    }

    public function getLastMonthOfTheLastYear(): Carbon
    {
        $lastYearEnd = $this->getTheEndOfTheLastYear();

        return $lastYearEnd->subMonthNoOverflow();
    }

    public function getTheEndOfTheLastYear(): Carbon
    {
        $currentDate = Carbon::now();

        // Why copy()? The copy() method in Carbon is used to create a new instance of a
        // Carbon date and time object that is a copy of the original object.
        // copy() is used to create a new Carbon object so that the original
        // object ($currentDate) remains unchanged while we perform
        // further modifications on the copied object
        return $currentDate->copy()->subYearNoOverflow()->endOfYear();
    }

    public function getTheNextMonth(): Carbon
    {
        return Carbon::now()->copy()->addMonthNoOverflow();
    }

    public function getTheLastMonth(): Carbon
    {
        return Carbon::now()->copy()->subMonthNoOverflow();
    }

    public function getCurrentDate(): Carbon
    {
        return Carbon::now()->copy();
    }

    public function getTheEndDateOfCurrentYear(): Carbon
    {
        return $this->getCurrentDate()->endOfYear();
    }

    public function getTheStartDateOfCurrentYear(): Carbon
    {
        return $this->getCurrentDate()->startOfYear();
    }
}
