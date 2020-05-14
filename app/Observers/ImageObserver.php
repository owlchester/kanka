<?php


namespace App\Observers;


use App\Facades\CampaignCache;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    /**
     * @param Image $image
     */
    public function deleted(Image $image)
    {
        Storage::disk(config('images.disk'))
            ->delete($image->path);

        CampaignCache::clearDefaultImages();
    }

    /**
     * @param Image $image
     */
    public function saved(Image $image)
    {
        CampaignCache::clearDefaultImages();
    }
}
