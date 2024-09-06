<?php

namespace App\Models;

use App\Services\Offers\OfferService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HandleFiles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    use HasFactory;
    use HandleFiles;

    public const RELATED_FILES_SUB_FOLDER = 'offers';

    protected $guarded = [];

    /**
     * Get the disk that logo, photos should be stored on.
     */
    public static function relatedFileDisk(): string
    {
        return config('filesystems.default') !== 'local' ? config('filesystems.default') : 'public';
    }

    public static function getRelatedFilesSubFolder(): string
    {
        return self::RELATED_FILES_SUB_FOLDER;
    }

     /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Offer $offer) {
            $offer->company_id = Auth::user()->profile_id;
        });

        static::deleting(function (Offer $offer) {
            (new OfferService)->destroyFile($offer);
        });
    }

    public function internShip(): BelongsTo
    {
        return $this->belongsTo(InternShip::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function candidacies(): HasMany {

        return $this->hasMany(Candidacy::class);

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
                'title',
                'description',
                'requirements',
                'responsibilities'
            ], $search);
        });
    }
}
