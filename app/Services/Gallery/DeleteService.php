<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;

class DeleteService
{
    use CampaignAware;

    public function delete(array $ids): int
    {
        // We need to loop them for the observers
        $count = 0;
        foreach ($ids as $id) {
            $image = Image::where('id', $id)->first();
            if (! $image) {
                continue;
            }
            $image->delete();
            $count++;
        }

        return $count;
    }
}
