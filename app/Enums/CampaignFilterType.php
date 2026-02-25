<?php

namespace App\Enums;

enum CampaignFilterType: int
{
    case Intro = 1;
    case Timezone = 2;
    case Schedule = 3;
    case PlayerCount = 4;
}
