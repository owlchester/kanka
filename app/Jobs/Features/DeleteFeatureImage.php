<?php

namespace App\Jobs\Features;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteFeatureImage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $featureImage;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->deleteImage();
    }

    private function deleteImage()
    {
        if (!Storage::exists($this->featureImage)) {
            // Image was deleted
            return;
        }
        Storage::delete($this->featureImage);
    }
}
