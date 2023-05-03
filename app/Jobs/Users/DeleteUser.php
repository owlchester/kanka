<?php

namespace App\Jobs\Users;

use App\Observers\UserObserver;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteUser implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var int */
    protected int $user;

    /**queue
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var User $user */
        $user = User::find($this->user);
        if (empty($user)) {
            // User wasn't found
            Log::warning('User delete: unknown #' . $this->user . '.');
            return;
        }

        User::observe(UserObserver::class);
        $user->delete();

        Log::info('User #' . $this->user . ' deleted (job)');
        unset($user);
    }
}
