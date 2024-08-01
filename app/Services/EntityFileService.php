<?php

namespace App\Services;

use App\Exceptions\EntityFileException;
use App\Http\Requests\StoreEntityAsset;
use App\Models\EntityAsset;
use App\Models\Image;
use App\Services\Campaign\GalleryService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class EntityFileService
{
    use CampaignAware;
    use EntityAware;

    /**
     * @throws EntityFileException
     */
    public function upload(StoreEntityAsset $request, string $field = 'file'): EntityAsset
    {
        /** @var GalleryService $service */
        $service = app()->make(GalleryService::class);

        // Prepare the file for the journey
        $uploadedFile = $request->file($field);

        // Already above max capacity?
        if ($this->entity->files->count() >= $this->campaign->maxEntityFiles() || $service->campaign($this->campaign)->available() < $uploadedFile->getSize() / 1024) {
            throw new EntityFileException('max');
        }

        $name = $request->get('name');
        if (empty($name)) {
            $name = $uploadedFile->getClientOriginalName();
            $name = Str::beforeLast($name, '.');
        }

        $image = new Image();
        $image->campaign_id = $this->campaign->id;
        $image->created_by = auth()->user()->id;
        $image->ext = $uploadedFile->extension();
        $image->size = (int) ceil($uploadedFile->getSize() / 1024); // kb
        $image->name = mb_substr($name, 0, 45);
        $image->visibility_id = $this->campaign->defaultVisibilityID();
        $image->save();

        $uploadedFile
            ->storePubliclyAs(
                $image->folder,
                $image->file,
                ['disk' => 's3']
            );

        $file = new EntityAsset();
        $file->type_id = EntityAsset::TYPE_FILE;
        $file->entity_id = $this->entity->id;
        $file->metadata = [
            'size' => $uploadedFile->getSize(),
            'type' => $uploadedFile->getMimeType(),
        ];
        $file->name = $name;
        $file->visibility_id = $request->get('visibility_id', 1);
        $file->is_pinned = $request->get('is_pinned', 1);
        $file->image_uuid = $image->id;
        $file->save();

        Cache::forget('campaign_' . $this->campaign->id . '_gallery');

        return $file;
    }
}
