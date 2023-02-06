<?php

namespace App\Services;

use App\Exceptions\EntityFileException;
use App\Http\Requests\StoreEntityAsset;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Traits\CampaignAware;

class EntityFileService
{
    use CampaignAware;

    /** @var Entity */
    protected $entity;

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @param StoreEntityAsset $request
     * @param string $field
     * @param string $folder
     * @return EntityAsset
     * @throws EntityFileException
     */
    public function upload(StoreEntityAsset $request, string $field = 'file', string $folder = 'entities/files'): EntityAsset
    {
        // Already above max capacity?
        if ($this->entity->files->count() >= $this->campaign->maxEntityFiles()) {
            throw new EntityFileException('max');
        }
        // Prepare the file for the journey
        $uploadedFile = $request->file($field);

        $path = $request->file($field)->storePublicly($folder);
        $name = $request->get('name');
        if (empty($name)) {
            $name = $uploadedFile->getClientOriginalName();
        }

        $file = new EntityAsset();
        $file->type_id = EntityAsset::TYPE_FILE;
        $file->entity_id = $this->entity->id;
        $file->metadata = [
            'path' => $path,
            'size' => $uploadedFile->getSize(),
            'type' => $uploadedFile->getMimeType(),
        ];
        $file->name = $name;
        $file->visibility_id = $request->get('visibility_id', 1);
        $file->is_pinned = $request->get('is_pinned', 1);
        $file->save();
        return $file;
    }
}
