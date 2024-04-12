<?php

namespace App\Enums;

enum WebhookAction: int
{
    case CREATED = 1;
    case EDITED = 2;
    case DELETED = 3;
}
