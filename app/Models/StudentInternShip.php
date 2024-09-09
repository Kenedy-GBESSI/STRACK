<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HandleFiles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentInternShip extends Model
{
    use HasFactory;
    use HandleFiles;

    public const RELATED_FILES_SUB_FOLDER = 'intern_ships_rapports_files';

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


    public function internShip(): BelongsTo
    {
        return $this->belongsTo(InternShip::class);
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
                'status'
            ], $search);
        });
    }

}
