<?php

namespace App\Services\Subscription;

use App\Enums\UserAction;
use App\Facades\UserLogger;
use App\Models\User;

class PaymentMethodService
{
    public function updateExpiry(User $user, UserAction $action)
    {
        $user->saveQuietly();
        UserLogger::user($user)->log($action);
    }
}
