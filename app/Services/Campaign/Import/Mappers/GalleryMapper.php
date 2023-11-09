<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Image;
use App\Traits\CampaignAware;

class GalleryMapper
{
    use CampaignAware;
    use ImportMapper;

    protected array $mapping = [];

    public function has(string $uuid): bool
    {
        return !empty($this->mapping[$uuid]);
    }

    public function get(string $uuid): string
    {
        return $this->mapping[$uuid];
    }

    public function import(): void
    {
        $image = new Image();
        $image->campaign_id = $this->campaign->id;

        $reset = ['created_at', 'updated_at']
        foreach ($this->data as $field => $value) {

        }

        $image->save();
    }
}
