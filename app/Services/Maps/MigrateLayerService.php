<?php

namespace App\Services\Maps;

use App\Exceptions\TranslatableException;
use App\Models\Image;
use App\Models\MapLayer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateLayerService
{
    protected MapLayer $layer;

    protected Image $image;

    public function layer(MapLayer $layer): self
    {
        $this->layer = $layer;
        return $this;
    }

    public function migrate(): void
    {
        if (empty($this->layer->image_path)) {
            throw new TranslatableException('maps/layers.migrate.empty');
        }

        $path = $this->layer->image_path;
        $ext = Str::afterLast('.', $path);

        $this->image = new Image();
        $this->image->campaign_id = $this->layer->map->campaign_id;
        $this->image->created_by = $this->layer->created_by;
        $this->image->name = $this->layer->name;
        $this->image->ext = $ext;
        $this->image->size = (int) ceil(Storage::fileSize($path) / 1024); // kb
        $this->image->visibility_id = $this->layer->visibility_id;
        $this->image->save();

        Storage::move($path, $this->image->path);

        $this->layer->image_path = null;
        $this->layer->image_uuid = $this->image->id;
        $this->layer->save();
    }
}
