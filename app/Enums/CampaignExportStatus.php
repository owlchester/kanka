<?php

namespace App\Enums;

enum CampaignExportStatus: int
{
    case scheduled = 1;
    case running = 2;
    case finished = 3;
    case failed = 4;
}
