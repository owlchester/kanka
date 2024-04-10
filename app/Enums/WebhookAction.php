<?php

namespace App\Enums;

enum WebhookAction: int
{
    case NEW = 1;
    case EDITED = 2;
    case DELETED = 3;
}
