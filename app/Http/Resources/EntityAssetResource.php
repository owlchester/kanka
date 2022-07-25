<?php

namespace App\Http\Resources;

use App\Models\EntityAsset;
use Illuminate\Support\Facades\Storage;

class EntityAssetResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityAsset $asset */
        $asset = $this->resource;

        $data = $this->entity([
            'type_id' => $asset->type_id,
            '_file' => $asset->isFile(),
            '_link' => $asset->isLink(),
            '_alias' => $asset->isAlias(),
            'name' => $asset->name,
            'metadata' => $asset->metadata,
            'visibility_id' => $asset->visibility_id,
        ]);

        if ($asset->isFile()) {
            $data['_url'] = Storage::url($asset->metadata['path']);
        }

        return $data;
    }
}
