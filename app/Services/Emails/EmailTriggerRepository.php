<?php

namespace App\Services\Emails;

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger as EmailTriggerEnum;
use App\Models\EmailTrigger;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @return Collection<int, EmailTrigger>
     */
    public function all(): Collection
    {
        return EmailTrigger::query()
            ->orderBy('trigger_id')
            ->orderBy('audience')
            ->orderBy('cohort')
            ->orderBy('id')
            ->get();
    }
}
