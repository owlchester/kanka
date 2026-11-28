<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Enums\UserAction;
use App\Facades\UserLogger;
use App\Mail\Subscription\User\YearlyNudgeMail;
use App\Models\User;
use App\Services\Subscription\YearlyNudgeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class YearlyNudgeAlert implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $userId;

    public function __construct(User $user)
    {
        $this->userId = $user->id;
    }

    public function handle(): void
    {
        /** @var User|null $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        $offer = app(YearlyNudgeService::class)->user($user)->offer();
        if ($offer === null) {
            return;
        }

        Mail::to($user->email)
            ->locale($user->locale)
            ->send(new YearlyNudgeMail(
                $user,
                $offer['tier']->name,
                $offer['savings'],
                $offer['currency_symbol'],
            ));

        UserLogger::user($user)->log(UserAction::subYearlyNudge);
    }
}
