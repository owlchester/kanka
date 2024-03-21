<?php

namespace App\Enums;

enum FeatureStatus: int
{
    case Draft = 1;
    case Rejected = 2;
    case Approved = 3;
    case  Later = 4;
    case Next = 5;
    case Now = 6;
    case Done = 7;
}
