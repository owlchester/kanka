<?php

namespace App\Jobs\Users;

use App\Services\Users\CleanupService;
use App\Models\User;
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

    /**  */
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
        /** @var User|null $user */
        $user = User::find($this->user);
        if (empty($user)) {
            // User wasn't found
            Log::warning('Jobs/Users/DeleteUser', ['unknown user', 'user' => $this->user]);
            return;
        }
        Log::info('Jobs/Users/DeleteUser', ['start', 'user' => $user->id]);

        /** @var CleanupService $service */
        // We don't use the model's observer, because in laravel 10, it's adding the observer for each loop in local dev, slowing everything down
        $service = app()->make(CleanupService::class);
        $service->user($user)->delete();
        $user->delete();
    }
}
