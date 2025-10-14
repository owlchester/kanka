<?php

namespace App\Enums;

enum OrganisationMemberPin: int
{
    case empty = 0; //Added to prevent a crash due to invalid value.
    case character = 1;
    case organisation = 2;
    case both = 3;
}
