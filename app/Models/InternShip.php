<?php

namespace App\Models;

use App\Services\InternShips\InternShipService;
use App\Traits\HandleFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class InternShip extends Model
{
    use HasFactory;
    use HandleFiles;

    public const RELATED_FILES_SUB_FOLDER = 'intern-ships';

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
     * @return array<mixed>
     */
    public static function toMultiselectFormat()
    {
        return self::ongoing()->select('id as value', 'title as label')
            ->orderBy('title', 'asc')
            ->get()
            ->toArray();
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (InternShip $internShip) {
            (new InternShipService)->destroyFile($internShip);
        });
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
                'start_date',
                'end_date',
                'academic_year',
            ], $search);
        });
    }

    /**
     * Scope a query to only include internships that are currently ongoing.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOngoing($query)
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        return $query->whereDate('start_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate);
    }
}
