<?php

namespace App\Enums;

enum CampaignExportStatus: int
{
    case SCHEDULED = 1;
    case RUNNING = 2;
    case FINISHED = 3;
    case FAILED = 4;
}
