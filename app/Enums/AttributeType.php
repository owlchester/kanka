<?php

namespace App\Enums;

enum AttributeType: int
{
    case Invalid = 0;
    case Standard = 1;
    case Block = 2;
    case Checkbox = 3;
    case Section = 4;
    case Random = 5;
    case Number = 6;
    case List = 7;
}
