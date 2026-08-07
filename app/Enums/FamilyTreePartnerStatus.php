<?php

namespace App\Enums;

enum FamilyTreePartnerStatus: string
{
    case Current = 'current';
    case Former = 'former';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
