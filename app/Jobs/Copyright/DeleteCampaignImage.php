<?php

namespace App\Jobs\Copyright;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteCampaignImage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $campaignId;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->deleteImage();

        Log::info('Removed image from campaign #' . $this->campaignId . ' for copyright reasons');
    }

    private function deleteImage()
    {
        $campaign = Campaign::find($this->campaignId);

        if (empty($campaign) || ! (Storage::exists($campaign->image))) {
            // Image was deleted
            return;
        }
        Storage::delete($campaign->image);
        $campaign->image = null;
        $campaign->saveQuietly();
    }
}
