<?php

namespace App\Jobs\Users;

use App\Services\NewsletterService;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->userId = $user->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var User|null $user */
        $user = User::find($this->userId);

        /** @var NewsletterService $newsletter */
        $newsletter = app()->make(NewsletterService::class);

        $newsletter->user($user)->update(['email' => $user->email]);
        Log::info('Newsletter', ['action' => 'update', 'user' => $user->id]);
    }
}
