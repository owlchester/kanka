<?php

namespace App\Jobs\Emails\Purge;

use App\Mail\Purge\SecondWarning;
use App\Models\User;
use App\Models\UserLog;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SecondWarningJob implements ShouldQueue
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
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        Log::info('PurgeFirstWarning', ['user' => $this->userId]);
        $campaigns = $user->onlyAdminCampaigns();
        $user->log(UserLog::PURGE_WARNING_SECOND);

        $target = app()->isProduction() ? $user->email : config('mail.from.address');
        try {
            Mail::to($target)
                ->locale($user->locale ?? 'en-US')
                ->send(
                    new SecondWarning($user, $campaigns)
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
