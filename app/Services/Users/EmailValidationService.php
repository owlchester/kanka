<?php

namespace App\Services\Users;

use App\Traits\UserAware;
use App\Models\UserFlag;
use App\Models\UserValidation;
use App\Jobs\Emails\Subscriptions\EmailValidationJob;
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
        //Check for existing token
        $flag = UserFlag::where('user_id', $this->user->id)->where('flag', UserFlag::FLAG_EMAIL)->first();

        if (!$flag) {
            $flag = new UserFlag();
            $flag->user_id = $this->user->id;
            $flag->flag = UserFlag::FLAG_EMAIL;
            $flag->save();
        }

        if (!$token) {
            $token = new UserValidation();
            $token->token = Str::uuid();
            $token->user_id = $this->user->id;
            $token->is_valid = false;
            $token->save();
        }

        EmailValidationJob::dispatch($this->user, $token->token);

        return;
    }
}
