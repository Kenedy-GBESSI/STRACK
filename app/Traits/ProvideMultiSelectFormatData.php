<?php

declare(strict_types=1);

namespace App\Traits;

trait ProvideMultiSelectFormatData
{
    /**
     * @return array<mixed>
     */
    public static function toMultiselectFormat()
    {
        return self::select('id as value', 'name as label')
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }
}
