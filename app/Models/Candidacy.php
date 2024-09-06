<?php

namespace App\Models;

use App\Services\Candidacy\CandidacyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HandleFiles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidacy extends Model
{
    use HasFactory;
    use HandleFiles;

    public const RELATED_FILES_SUB_FOLDER = 'cvs';

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
        static::deleting(function (Candidacy $candidacy) {
            (new CandidacyService)->destroyFile($candidacy);
        });
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
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
                'offer.title',
                'offer.description',
                'offer.requirements',
                'offer.responsibilities',
                'status'
            ], $search);
        })->when($filters['candidacy_status'] ?? null, function ($query, $candidacyStatus) {

            $query->where('status', $candidacyStatus);

        });
    }

}
