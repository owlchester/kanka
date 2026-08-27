<?php

namespace App\Enums;

enum InteractionLogVisibility: string
{
    case Player = 'player';
    case Gm = 'gm';
    case Shared = 'shared';
}
