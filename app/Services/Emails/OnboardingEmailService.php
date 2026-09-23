<?php

namespace App\Services\Emails;

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger as EmailTriggerEnum;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\User;
use Carbon\Carbon;

class OnboardingEmailService
{
    public function __construct(protected EmailTriggerDeliveryService $deliveries) {}

    public function sendWelcome(User $user): bool
    {
        $campaign = $this->firstAdminCampaign($user);
        $audience = EmailAudience::Gm;

        if ($campaign === null) {
            $campaign = $this->firstCampaign($user);
            $audience = EmailAudience::Player;
        }

        if ($campaign === null) {
            return false;
        }

        return $this->deliveries->send(
            $user,
            EmailTriggerEnum::Welcome,
            $audience,
            'welcome',
            route('dashboard', ['campaign' => $campaign]),
        );
    }

    public function campaignForAudience(User $user, EmailAudience $audience): ?Campaign
    {
        return match ($audience) {
            EmailAudience::Gm => $this->firstAdminCampaign($user),
            EmailAudience::Player => $this->firstCampaign($user),
        };
    }

    public function sendDayOne(User $user): bool
    {
        $campaign = $this->firstAdminCampaign($user);
        if ($campaign === null) {
            return false;
        }

        $trigger = $this->hasUserEntities($user)
            ? EmailTriggerEnum::Momentum
            : EmailTriggerEnum::Nudge;

        return $this->deliveries->send(
            $user,
            $trigger,
            EmailAudience::Gm,
            'day_one',
            route('dashboard', ['campaign' => $campaign]),
        );
    }

    public function sendDayThree(User $user): bool
    {
        $campaign = $this->firstAdminCampaign($user);
        if ($campaign === null || (! $this->hasUserEntities($user) && ! $this->hasLoggedInAgain($user))) {
            return false;
        }

        return $this->deliveries->send(
            $user,
            EmailTriggerEnum::Connections,
            EmailAudience::Gm,
            'day_three',
            route('dashboard', ['campaign' => $campaign]),
        );
    }

    public function firstAdminCampaign(User $user): ?Campaign
    {
        return Campaign::query()
            ->whereHas('roles', function ($roles) use ($user): void {
                $roles
                    ->where('is_admin', true)
                    ->whereHas('users', fn ($users) => $users->where('user_id', $user->id));
            })
            ->orderBy('campaigns.created_at')
            ->orderBy('campaigns.id')
            ->first();
    }

    protected function firstCampaign(User $user): ?Campaign
    {
        return $user->campaigns()
            ->orderBy('campaigns.created_at')
            ->orderBy('campaigns.id')
            ->first();
    }

    protected function hasUserEntities(User $user): bool
    {
        return Entity::query()
            ->where('created_by', $user->id)
            ->where('source', 'user')
            ->exists();
    }

    protected function hasLoggedInAgain(User $user): bool
    {
        $lastLogin = $user->getRawOriginal('last_login_at');

        return $lastLogin !== null
            && Carbon::parse($lastLogin)->gt($user->created_at);
    }
}
