<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Pagination\LengthAwarePaginator;

class TiptapService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

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

        $query = Image::where('campaign_id', $this->campaign->id)
            ->acl($canBrowse)
            ->search($this->request->get('folder'), $this->request->get('term'))
            ->where('is_default', false)
            ->withoutFonts()
            ->orderBy('is_folder', 'desc');

        match ($this->request->get('sort')) {
            'name_asc' => $query->orderBy('name', 'asc')->orderBy('updated_at', 'desc'),
            'name_desc' => $query->orderBy('name', 'desc')->orderBy('updated_at', 'desc'),
            default => $query->orderBy('updated_at', 'desc'),
        };

        $images = $query->paginate(50);

        return $images;

    }
}
