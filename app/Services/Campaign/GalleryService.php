<?php


namespace App\Services\Campaign;


use App\Models\Campaign;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryService
{
    /** @var Campaign */
    protected $campaign;

    /** @var Image */
    protected $image;

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
     * @param Image $image
     * @return $this
     */
    public function image(Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param Request $request
     * @param string $field
     * @return Image
     */
    public function store(Request $request, string $field = 'file'): Image
    {
        // Create new image
        $uuid = Str::uuid()->toString();

        /** @var \Illuminate\Http\UploadedFile $source */
        $source = $request->file($field);

        // Prepare the name as sent by the user. It gets purified in the observer
        $name = $source->getClientOriginalName();
        $name = Str::beforeLast($name, '.');

        $image = new Image();
        $image->campaign_id = $this->campaign->id;
        $image->created_by = $request->user()->id;
        $image->id = $uuid;
        $image->ext = $source->extension();
        $image->size = ceil($source->getSize() / 1024); // kb
        $image->name = substr($name, 0, 45);
        $image->save();

        $source
            ->storePubliclyAs(
                $image->folder,
                $image->file
            );

        return $image;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function update(string $name): self
    {
        $this->image->update([
            'name' => $name
        ]);

        return $this;
    }
}
