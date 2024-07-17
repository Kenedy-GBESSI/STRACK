<?php

declare(strict_types=1);

namespace App\Enums;

enum StudyField: string
{
    case SOFTWARE_ENGINEERING = 'GL';
    case CYBERSECURITY = 'SI';
    case INTERNET_MULTIMEDIA = 'IM';

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
}
