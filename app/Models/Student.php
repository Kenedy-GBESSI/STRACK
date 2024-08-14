<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->morphOne(User::class, 'profile', 'profile_type', 'profile_id');
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
                'internship_status',
            ], $search);
        })->when($filters['study_field'] ?? null, function ($query, $studyField) {

            $query->where('study_field', $studyField);

        })->when($filters['internship_status'] ?? null, function ($query, $internshipStatus) {

            $query->where('internship_status', $internshipStatus);

        });
    }

}
