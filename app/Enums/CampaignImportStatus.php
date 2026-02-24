<?php

namespace App\Enums;

enum CampaignImportStatus: int
{
    case PREPARED = 1;
    case QUEUED = 2;
    case RUNNING = 3;
    case FINISHED = 4;
    case FAILED = 5;
    case VALIDATING = 6;
    case READY = 7;
    case PROCESSING = 8;
}
