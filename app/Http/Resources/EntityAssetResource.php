<?php

namespace App\Http\Resources;

use App\Enums\EntityAssetType;
use App\Models\EntityAsset;
use Illuminate\Http\Request;

class EntityAssetResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityAsset $asset */
        $asset = $this->resource;
        // EntityAsset has an enum cast, but old rows may contain an invalid type.
        // Read the raw value here so one bad asset cannot break the whole response.
        $type = EntityAssetType::tryFrom((int) $asset->getRawOriginal('type_id'));

        $data = $this->onEntity([
            'type_id' => $type?->value,
            '_file' => $type === EntityAssetType::file,
            '_link' => $type === EntityAssetType::link,
            '_alias' => $type === EntityAssetType::alias,
            'name' => $asset->name,
            'metadata' => $asset->metadata,
            'visibility_id' => $asset->visibility_id,
            'is_pinned' => (bool) $asset->isPinned(),
        ]);

        if ($type === EntityAssetType::file) {
            $data['_url'] = $asset->url();
        }

        return $data;
    }
}
