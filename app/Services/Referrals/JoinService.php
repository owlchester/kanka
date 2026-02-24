<?php

namespace App\Services\Referrals;

use App\Enums\ReferralEventType;
use App\Models\Concerns\HasUser;
use App\Models\Referral;
use App\Models\ReferralEvent;
use App\Models\User;

class JoinService
{
    use HasUser;

    protected ?Referral $referral;

    public function referral(Referral $referral): self
    {
        $this->referral = $referral;

        return $this;
    }

    public function expired(): bool
    {
        return $this->referral->revoked_at !== null;
    }

    public function flag(): void
    {
        session()->put('referral_code', $this->referral->code);
    }

    public function referrer(): ?int
    {
        if (! session()->has('referral_code')) {
            return null;
        }

        $code = session()->get('referral_code');
        session()->forget('referral_code');

        $this->referral = Referral::where('code', $code)->first();

        return $this->referral?->user_id;
    }

    public function event(User $user, ReferralEventType $type): void
    {
        if (! isset($this->referral)) {
            return;
        }
        $event = new ReferralEvent;
        $event->created_by = $user->id;
        $event->referred_by = $this->referral->user_id;
        $event->type = $type;
        $event->save();
    }
}
