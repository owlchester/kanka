<?php

namespace App\Enums;

enum EntityAssetType: int
{
    case FILE = 1;
    case LINK = 2;
    case ALIAS = 3;
}
