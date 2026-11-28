<?php

namespace App\Enums;

enum UserFlags: string
{
    case firstWarning = 'inactive_1';
    case secondWarning = 'inactive_2';

    case email = 'email';
    case freeTrial = 'free_trial';
    case startTrial = 'start_trial';
    case subPaused = 'sub_paused';
    case uploadSize = 'upload_size';
    case yearlyNudge = 'yearly_nudge';
}
