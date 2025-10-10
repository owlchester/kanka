<?php

namespace App\Enums;

enum OrganisationMemberStatus: int
{
    case ACTIVE = 0;
    case INACTIVE = 1;
    case UNKNOWN = 2;
}
