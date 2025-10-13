<?php

namespace App\Enums;

enum EntityEventTypes: int
{
    case BIRTH = 2;
    case DEATH = 3;
    case CALENDAR_DATE = 4;
    case FOUNDED = 5;
}
