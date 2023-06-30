<?php

namespace App\Jobs\Emails\Purge;

use App\Mail\Purge\FirstWarning;
use App\Models\CampaignRole;
use App\Models\UserLog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FirstWarningJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        Log::info('PurgeFirstWarning', ['user' => $this->userId]);
        $campaigns = $user->onlyAdminCampaigns();
        $user->log(UserLog::PURGE_WARNING_FIRST);

        try {
            Mail::to($user->email)
                ->locale($user->locale ?? 'en-US')
                ->send(
                    new FirstWarning($user, $campaigns)
                );
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            // Silence
        } catch (\Exception $e) {
            // Something went wrong with mailgun, or the email is invalid. Silence these errors
            // to avoid spamming sentry.
            throw $e;
        }
    }
}
