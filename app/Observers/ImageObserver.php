<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    public function deleting(Image $image)
    {
        if (! $image->isFolder()) {
            return;
        }

        // Delete any images in the folder first
        foreach ($image->images as $img) {
            $img->delete();
        }
    }

    public function deleted(Image $image)
    {
        Storage::disk(config('images.disk'))
            ->delete($image->path);

        CampaignCache::clear();
    }

    public function saved(Image $image)
    {
        CampaignCache::clear();
    }
}
