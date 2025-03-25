<?php

namespace App\Services;

use App\Exceptions\TranslatableException;
use App\Http\Requests\StoreEntityAsset;
use App\Http\Requests\StoreEntityAssets;
use App\Models\EntityAsset;
use App\Models\Image;
use App\Services\Gallery\StorageService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class EntityFileService
{
    use CampaignAware;
    use EntityAware;

    protected array $files;

    /**
     * @throws TranslatableException
     */
    public function upload(StoreEntityAsset|StoreEntityAssets $request, string $field = 'files'): self
    {
        /** @var StorageService $service */
        $service = app()->make(StorageService::class);
        $this->files = [];

        // Prepare the file for the journey
        $uploadedFiles = $request->file($field);
        if (! is_array($uploadedFiles)) {
            $uploadedFiles = [$uploadedFiles];
        }
        $files = [];
        foreach ($uploadedFiles as $uploadedFile) {
            // Already above max capacity?
            if ($this->entity->files->count() >= $this->campaign->maxEntityFiles()) {
                throw (new TranslatableException('crud.files.errors.max'))
                    ->setOptions(['max' => $this->campaign->maxEntityFiles()]);
            }
            if ($service->campaign($this->campaign)->available() < $uploadedFile->getSize() / 1024) {
                $key = 'gallery.download.errors.gallery_full_free';
                if ($this->campaign->boosted()) {
                    $key = 'gallery.download.errors.gallery_full_premium';
                }
                throw new TranslatableException($key);
            }

            $name = $request->get('name');
            if (empty($name)) {
                $name = $uploadedFile->getClientOriginalName();
                $name = Str::beforeLast($name, '.');
            }

            $image = new Image;
            $image->campaign_id = $this->campaign->id;
            $image->ext = $uploadedFile->extension();
            $image->size = (int) ceil($uploadedFile->getSize() / 1024); // kb
            $image->name = mb_substr($name, 0, 45);
            $image->visibility_id = $this->campaign->defaultGalleryVisibility();
            $image->save();

            $uploadedFile
                ->storePubliclyAs(
                    $image->folder,
                    $image->file,
                    ['disk' => 's3']
                );

            $file = new EntityAsset;
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
            $this->files[] = $file;
        }

        return $this;
    }

    public function files(): array
    {
        return $this->files;
    }
}
