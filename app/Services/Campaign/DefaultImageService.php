<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Models\Image;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DefaultImageService
{
    use CampaignAware;

    protected string $type;

    /**
     * @return $this
     */
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     */
    public function save(Request $request): bool
    {
        // Does the campaign already have this type? If yes, let's stop
        $images = $this->campaign->default_images;
        if ($images === null) {
            $images = [];
        }
        if (Arr::has($images, $this->type)) {
            return false;
        }
        /** @var \Illuminate\Http\UploadedFile $source */
        $source = $request->file('default_entity_image');

        $image = new Image();
        $image->campaign_id = $this->campaign->id;
        $image->created_by = $request->user()->id;
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

        $images[$this->type] = $image->id;
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

        if (!isset($images[$this->type])) {
            return false;
        }
        /** @var ?Image $image */
        $image = Image::find($images[$this->type]);
        if (empty($image)) {
            return false;
        }
        $image->delete();

        unset($images[$this->type]);
        $this->campaign->default_images = $images;
        $this->campaign->saveQuietly();

        CampaignCache::clear();

        return true;
    }
}
