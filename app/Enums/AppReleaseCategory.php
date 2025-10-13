<?php

namespace App\Enums;

enum AppReleaseCategory: int
{
    case RELEASE = 1;
    case EVENT = 2;
    case VOTE = 3;
    case OTHER = 4;
    case LIVESTREAM = 5;
}
