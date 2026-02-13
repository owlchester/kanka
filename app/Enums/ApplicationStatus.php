<?php

namespace App\Enums;

enum ApplicationStatus: int
{
    case Pending = 0;
    case Approved = 1;
    case Rejected = 2;
}
