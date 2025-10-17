<?php

namespace App\Jobs\Emails\Purge;

use App\Enums\UserAction;
use App\Mail\Purge\FirstWarning;
use App\Models\User;
use App\Services\Users\CampaignService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FirstWarningJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 1;

    protected int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var User $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        Log::info('PurgeFirstWarning', ['user' => $this->userId]);

        /** @var CampaignService $service */
        $service = app()->make(CampaignService::class);
        $campaigns = $service->user($user)->flaggedCampaigns();
        $user->log(UserAction::purgeWarningFirst);

        $target = app()->isProduction() ? $user->email : config('mail.from.address');
        if (empty($target)) {
            return;
        }
        try {
            Mail::to($target)
                ->locale($user->locale ?? 'en-US')
                ->send(
                    new FirstWarning($user, $campaigns)
                );
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            // Silence
        } catch (Exception $e) {
            // Something went wrong with mailgun, or the email is invalid. Silence these errors
            // to avoid spamming sentry.
            throw $e;
        }
    }
}
