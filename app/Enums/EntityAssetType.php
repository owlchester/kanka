<?php

namespace App\Enums;

enum EntityAssetType: int
{
    case file = 1;
    case link = 2;
    case alias = 3;
}
