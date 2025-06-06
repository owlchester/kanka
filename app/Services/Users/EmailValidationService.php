<?php

namespace App\Services\Users;

use App\Jobs\Emails\Subscriptions\EmailValidationJob;
use App\Models\UserFlag;
use App\Models\UserValidation;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class EmailValidationService
{
    use UserAware;

    public function requiresEmail(): void
    {
        $token = UserValidation::where('user_id', $this->user->id)->first();
        if ($token && $token->is_valid) {
            return;
        }

        $flag = UserFlag::where('user_id', $this->user->id)
            ->where('flag', \App\Enums\UserFlag::email->value)
            ->first();
        // If we've already notified the user, no need to notify them again
        if ($flag) {
            return;
        }

        $flag = new UserFlag;
        $flag->user_id = $this->user->id;
        $flag->flag = \App\Enums\UserFlag::email;
        $flag->save();

        $token = new UserValidation;
        $token->token = Str::uuid();
        $token->user_id = $this->user->id;
        $token->is_valid = false;
        $token->save();

        EmailValidationJob::dispatch($this->user, $token);
    }
}
