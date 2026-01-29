<?php

namespace App\Services\Gallery;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Pagination\LengthAwarePaginator;

class TiptapService
{
    use CampaignAware;
    use UserAware;
    use RequestAware;

    public function images()
    {
        return $this->setup();
    }

    /**
     * Return the initial gallery view: folders and up to 50 images
     */
    protected function setup(): LengthAwarePaginator
    {
        $canBrowse = $this->user->can('galleryBrowse', $this->campaign);

        $images = Image::acl($canBrowse)
            ->search($this->request->get('folder'), $this->request->get('term'))
            ->where('is_default', false)
            ->orderBy('is_folder', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(50);

        return $images;

    }
}
