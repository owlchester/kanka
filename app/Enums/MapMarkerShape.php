<?php

namespace App\Enums;

enum MapMarkerShape: int
{
    case MARKER = 1;
    case LABEL = 2;
    case CIRCLE = 3;
    case POLY = 5;
}
