<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile', 'profile_type', 'profile_id');
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
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
                'company_name',
                'user.last_name',
                'user.first_name',
                'user.email',
            ], $search);
        })->when($filters['partnership_status'] ?? null, function ($query, $partnershipStatus) {

            $query->where('partnership_status', $partnershipStatus);

        });
    }
}
