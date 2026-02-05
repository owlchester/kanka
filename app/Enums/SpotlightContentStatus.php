<?php

namespace App\Enums;

enum SpotlightContentStatus: int
{
    case draft = 1;
    case applied = 2;
    case approved = 3;
    case rejected = 4;
}
