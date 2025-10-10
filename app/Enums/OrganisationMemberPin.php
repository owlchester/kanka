<?php

namespace App\Enums;

enum OrganisationMemberPin: int
{
    case CHARACTER = 1;
    case ORGANISATION = 2;
    case BOTH = 3;
}
