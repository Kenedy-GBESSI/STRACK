<?php

declare(strict_types=1);

namespace App\Enums;

enum InternshipStatus: string
{
    case ON_INTERNSHIP = 'En stage';
    case INTERNSHIP_FINISHED = 'Fin de stage';
    case NOT_ONE_INTERNSHIP = 'Pas en stage';

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
