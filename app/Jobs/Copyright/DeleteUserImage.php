<?php

namespace App\Jobs\Copyright;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteUserImage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $userId;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->deleteImage();

        Log::info('Removed image from user #' . $this->userId . ' for copyright reasons');
    }

    private function deleteImage()
    {
        $user = User::where('id', $this->userId)->first();

        if (empty($user) || !(Storage::exists($user->avatar))) {
            // Image was deleted
            return;
        }
        Storage::delete($user->avatar);
        $user->avatar = null;
        $user->saveQuietly();
    }
}
