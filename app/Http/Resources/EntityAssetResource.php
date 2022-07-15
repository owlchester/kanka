<?php

namespace App\Http\Resources;

use App\Models\EntityAsset;

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

        return $this->entity([
            'type_id' => $asset->type_id,
            '_file' => $asset->isFile(),
            '_link' => $asset->isLink(),
            '_alias' => $asset->isAlias(),
            'name' => $asset->name,
            'metadata' => $asset->metadata,
            'visibility_id' => $asset->visibility_id,
            'is_pinned' => (bool) $asset->is_pinned,
        ]);
    }
}
