<?php

namespace App\Enums;

enum QuestStatus: int
{
    case notStarted = 0;
    case ongoing = 1;
    case completed = 2;
    case abandoned = 3;
}
