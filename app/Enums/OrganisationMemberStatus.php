<?php

namespace App\Enums;

enum OrganisationMemberStatus: int
{
    case active = 0;
    case inactive = 1;
    case unknown = 2;
}
