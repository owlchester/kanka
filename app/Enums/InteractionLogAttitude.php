<?php

namespace App\Enums;

enum InteractionLogAttitude: string
{
    case Tense = 'tense';
    case Warm = 'warm';
    case Suspicious = 'suspicious';
    case Funny = 'funny';
    case Frightening = 'frightening';
}
