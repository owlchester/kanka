<?php

namespace App\Enums;

enum Visibility: int
{
    case All = 1;
    case Admin = 2;
    case AdminSelf = 3;
    case Self = 4;
    case Member = 5;
}
