<?php

namespace App\Models;

use App\Enums\InternshipStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'internship_status',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile', 'profile_type', 'profile_id');
    }

    public function studentInternShips(): HasMany
    {
        return $this->hasMany(StudentInternShip::class);
    }

    public function internShip(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->studentInternShips()->count() === 1 ? $this->studentInternShips()->with('student', 'internShip')->first() : null,
        );
    }

    /**
     * Scope a query to only include models based on search.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static  $query
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            /** @see \App\Providers\MacrosServiceProvider */
            $query->whereLike([
                'matriculation_number',
                'user.last_name',
                'user.first_name',
                'study_field',
                'user.email',
            ], $search);
        })->when($filters['study_field'] ?? null, function ($query, $studyField) {

            $query->where('study_field', $studyField);
        })->when($filters['internship_status'] ?? null, function ($query, $internshipStatus) {

            if ($internshipStatus === InternshipStatus::NOT_ONE_INTERNSHIP->value) {
                $query->doesntHave('internShip');
            } else {

                $query->whereHas('internShip', function ($subQuery) use ($internshipStatus) {

                    $subQuery->where(function ($q) use ($internshipStatus) {

                        if ($internshipStatus === InternshipStatus::INTERNSHIP_FINISHED->value) {

                            $q->whereDate('end_date', '<', now());
                        } elseif ($internshipStatus === InternshipStatus::ON_INTERNSHIP->value) {

                            $q->where('end_date', '>=', now());
                        }
                    });
                });
            }
        });
    }

    public function getInternshipStatusAttribute(): string
    {
        $internship = $this->internShip;

        if (! is_null($internship)) {

            $endDate = $internship->end_date;

            if ($endDate && $endDate->isPast()) {
                return InternshipStatus::INTERNSHIP_FINISHED->value;
            }

            return InternshipStatus::ON_INTERNSHIP->value;
        }

        return InternshipStatus::NOT_ONE_INTERNSHIP->value;
    }
}
