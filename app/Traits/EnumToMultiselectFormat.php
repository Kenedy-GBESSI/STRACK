<?php

declare(strict_types=1);

namespace App\Traits;

trait EnumToMultiSelectFormat
{
    /**
     * @return array<int,mixed>
     */
    public static function toMultiselectFormat(): array
    {
        return array_map(function (self $case) {
            return ['value' => $case->value, 'label' => self::getLabel($case)];
        }, self::cases());
    }

    abstract public static function getLabel(null|self|string $value): ?string;
}
