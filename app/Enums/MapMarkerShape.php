<?php

namespace App\Enums;

enum MapMarkerShape: int
{
    case marker = 1;
    case label = 2;
    case circle = 3;
    case poly = 5;
}
