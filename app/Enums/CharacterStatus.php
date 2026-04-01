<?php

namespace App\Enums;

enum CharacterStatus: int
{
    case alive = 0;
    case dead = 1;
    case missing = 2;
}
