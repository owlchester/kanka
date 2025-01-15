<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DefaultImageService
{
    use CampaignAware;
    use EntityTypeAware;

    /**
     */
    public function save(Request $request): bool
    {
        // Does the campaign already have this type? If yes, let's stop
        $images = $this->campaign->default_images;
        if ($images === null) {
            $images = [];
        }
        if (Arr::has($images, $this->entityType->pluralCode())) {
            return false;
        }
        /** @var \Illuminate\Http\UploadedFile $source */
        $source = $request->file('default_entity_image');

        $image = new Image();
        $image->campaign_id = $this->campaign->id;
        $image->ext = $source->extension();
        $image->size = (int) ceil($source->getSize() / 1024); // kb
        $image->name = mb_substr($source->getFileName(), 0, 45);
        $image->is_default = true;
        $image->save();

        $source
            ->storePubliclyAs(
                $image->folder,
                $image->file
            );

        $images[$this->entityType->pluralCode()] = $image->id;
        $this->campaign->default_images = $images;
        $this->campaign->saveQuietly();

        CampaignCache::clear();

        return true;
    }

    /**
     * Remove a default image
     */
    public function destroy(): bool
    {
        $images = $this->campaign->default_images;
        if ($images === null) {
            $images = [];
        }

        if (!isset($images[$this->entityType->pluralCode()])) {
            return false;
        }
        /** @var ?Image $image */
        $image = Image::find($images[$this->entityType->pluralCode()]);
        if (empty($image)) {
            return false;
        }
        $image->delete();

        unset($images[$this->entityType->pluralCode()]);
        $this->campaign->default_images = $images;
        $this->campaign->saveQuietly();

        CampaignCache::clear();

        return true;
    }
}
