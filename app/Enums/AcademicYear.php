<?php

declare(strict_types=1);

namespace App\Enums;

enum AcademicYear: string
{
    case FIRST_YEAR = 'Première Année';
    case SECOND_YEAR = 'Deuxième Année';
    case THIRD_YEAR = 'Troisième Année';
    case MASTER_1 = 'Master I';
    case MASTER_2 = 'Master II';

    public static function getLabel(self $value): string
    {
        return $value->value;
    }

    /**
     * Get all values of stock movement document
     *
     * @return array<mixed>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return self::getLabel($this);
    }

    /**
     * @return array<int,mixed>
     */
    public static function toMultiselectFormat(): array
    {
        return array_map(function (self $case) {
            return ['value' => $case->value, 'label' => self::getLabel($case)];
        }, self::cases());
    }
}
