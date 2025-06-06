<?php

namespace App\Enums;

enum UserFlag: string
{
    case firstWarning = 'inactive_1';
    case secondWarning = 'inactive_2';

    case email = 'email';
    case freeTrial = 'free_trial';
}
