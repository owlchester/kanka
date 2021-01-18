<?php


namespace App\Observers;


use App\Facades\CampaignCache;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    use PurifiableTrait;

    /**
     * @param Image $image
     */
    public function saving(Image $image)
    {
        $image->name = $this->purify($image->name);
    }

    public function deleting(Image $image)
    {
        if (!$image->is_folder) {
            return;
        }

        // Delete any images in the folder first
        foreach ($image->images as $img) {
            $img->delete();
        }
    }
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
