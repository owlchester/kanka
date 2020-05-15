<?php


namespace App\Services\Campaign;


use App\Models\Campaign;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DefaultImageService
{
    /** @var Campaign */
    protected $campaign;

    /** @var string */
    protected $type;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param Request $request
     * @return bool
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

        // Create new image
        $uuid = Str::uuid()->toString();

        /** @var \Illuminate\Http\UploadedFile $source */
        $source = $request->file('default_entity_image');

        $image = new Image();
        $image->campaign_id = $this->campaign->id;
        $image->created_by = $request->user()->id;
        $image->id = $uuid;
        $image->ext = $source->extension();
        $image->size = ceil($source->getSize() / 1024); // kb
        $image->name = substr($source->getFileName(), 0, 45);
        $image->save();

        $path = $source
            ->storePubliclyAs(
                $image->folder,
                $image->file
            );


        $images[$this->type] = $uuid;
        $this->campaign->default_images = $images;
        $this->campaign->withObservers = false;
        $this->campaign->save();

        return true;
    }

    /**
     * Remove a default image
     * @return bool
     */
    public function destroy(): bool
    {
        $images = $this->campaign->default_images;
        if ($images === null) {
            $images = [];
        }

        /** @var Image $image */
        $image = Image::findOrFail($images[$this->type]);
        $image->delete();

        unset($images[$this->type]);
        $this->campaign->default_images = $images;
        $this->campaign->withObservers = false;
        $this->campaign->save();

        return true;
    }
}
