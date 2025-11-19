<?php

namespace App\Enums;

enum CampaignVisibility: int
{
    case private = 1;
    case public = 3;
    case unlisted = 4;
}
