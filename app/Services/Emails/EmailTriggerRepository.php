<?php

namespace App\Services\Emails;

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger as EmailTriggerEnum;
use App\Models\EmailTrigger;

class EmailTriggerRepository
{
    public function find(EmailTriggerEnum $trigger, EmailAudience $audience): ?EmailTrigger
    {
        return EmailTrigger::query()
            ->where('is_active', true)
            ->where('trigger_id', $trigger->value)
            ->where('audience', $audience->value)
            ->whereNull('cohort')
            ->first();
    }
}
