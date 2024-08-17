<?php

namespace App\Services\Gallery;

use App\Http\Requests\Gallery\CreateFolder;
use App\Http\Resources\GalleryFile;
use App\Models\Image;
use App\Traits\CampaignAware;

class CreateService
{
    use CampaignAware;

    public function create(CreateFolder $request): GalleryFile
    {
        $folder = new Image();
        $folder->campaign_id = $this->campaign->id;
        $folder->folder_id = $request->get('folder_id');
        $folder->name = $request->get('name');
        $folder->visibility_id = $request->get('visibility_id');
        $folder->is_folder = true;
        $folder->save();

        return (new GalleryFile($folder))->campaign($this->campaign);
    }
}
