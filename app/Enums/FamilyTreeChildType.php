<?php

namespace App\Enums;

enum FamilyTreeChildType: int
{
    case Biological = 1;
    case Adopted = 2;
    case Step = 3;
    case Foster = 4;
    case Custom = 5;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
