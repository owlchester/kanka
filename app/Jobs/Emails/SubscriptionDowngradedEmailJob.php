<?php

namespace App\Jobs\Emails;

use App\Mail\Subscription\Admin\DowngradedSubscriptionMail;
use App\Models\Tier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionDowngradedEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $userId;

    public ?string $reason;

    public ?string $custom;

    public ?int $newTierId;

    public ?string $oldPledge;

    public int $tries = 3;

    public function __construct(User $user, ?string $reason = null, ?string $custom = null, ?Tier $newTier = null, ?string $oldPledge = null)
    {
        $this->userId = $user->id;
        $this->reason = $reason;
        $this->custom = $custom;
        $this->newTierId = $newTier?->id;
        $this->oldPledge = $oldPledge;
    }

    public function handle()
    {
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        $reason = $this->reason === 'custom' ? 'other' : $this->reason;
        $newTier = $this->newTierId ? Tier::find($this->newTierId) : null;

        Mail::to('hello@kanka.io')
            ->send(new DowngradedSubscriptionMail($user, $reason, $this->custom, $newTier, $this->oldPledge));
    }
}
