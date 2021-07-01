<?php

namespace App\Services;

use App\Exceptions\EntityFileException;
use App\Http\Requests\StoreEntityFile;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityFile;

class EntityFileService
{
    /** @var Entity */
    protected $entity;

    /** @var Campaign */
    protected $campaign;

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
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param string $file
     */
    public function upload(StoreEntityFile $request, $field = 'file', $folder = 'entities/files'): EntityFile
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

        $file = new EntityFile();
        $file->entity_id = $this->entity->id;
        $file->created_by = auth()->user()->id;
        $file->path = $path;
        $file->name = $name;
        $file->size = $uploadedFile->getSize();
        $file->type = $uploadedFile->getMimeType();
        $file->visibility = $request->get('visibility', 'all');
        $file->save();
        return $file;
    }
}
