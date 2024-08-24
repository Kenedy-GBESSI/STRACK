<?php

namespace App\Models;

use App\Services\InternShips\InternShipService;
use App\Traits\HandleFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                'description'
            ], $search);
        });
    }
}
