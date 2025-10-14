<?php

namespace App\Enums;

enum AppReleaseCategory: int
{
    case release = 1;
    case event = 2;
    case vote = 3;
    case other = 4;
    case livestream = 5;
}
