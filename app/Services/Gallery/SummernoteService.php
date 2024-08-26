<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Http\Requests\Campaigns\GalleryImageStore;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class SummernoteService
{
    use CampaignAware;
    use UserAware;

    protected StorageService $storage;

    public function __construct(StorageService $storageService)
    {
        $this->storage = $storageService;
    }

    public function store(GalleryImageStore $request, string $field = 'file'): array
    {
        $images = [];
        $files = $request->file($field);
        if (!is_array($files)) {
            $files = [$files];
        }
        $available = $this->storage->campaign($this->campaign)->available();
        foreach ($files as $source) {
            // Prepare the name as sent by the user. It gets purified in the observer
            if (empty($source)) {
                continue;
            }
            $name = $source->getClientOriginalName();
            $name = Str::beforeLast($name, '.');

            $image = new Image();
            $image->campaign_id = $this->campaign->id;
            $image->ext = $source->extension();
            $image->size = (int) ceil($source->getSize() / 1024); // kb
            $image->name = mb_substr($name, 0, 45);
            $image->folder_id = $request->post('folder_id');
            $image->visibility_id = $this->campaign->defaultGalleryVisibility();

            // Check remaining space again before saving, as the user could be near max and uploading multiple
            // files at a time to bypass the size restrictions
            $available -= $image->size;
            if ($available < 0) {
                continue;
            }

            $image->save();

            $source
                ->storePubliclyAs(
                    $image->folder,
                    $image->file,
                    ['disk' => 's3']
                );

            $images[] = $image;
        }

        $this->storage->clearCache();
        return $images;
    }
}
