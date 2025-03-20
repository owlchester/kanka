<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Str;

trait ThumbnailCache
{
    /**
     * Default Entity Images for a campaign
     */
    public function defaultImages(): array
    {
        $data = $this->primary($this->campaign->id)->get('thumbnails', null);
        // Since thumbnails come from the db, we need to load them _after_ permissions/campaign roles have been loaded.
        // It's an extra back and forth with redis on the first init of a clear cache
        if (is_array($data)) {
            return $data;
        }

        return $this->append($this->campaign->id, 'thumbnails', $this->formatThumbnails());
    }

    protected function formatThumbnails(): array
    {
        $defaults = $this->campaign->defaultImages();
        $data = [];
        foreach ($defaults as $default) {
            $data[Str::singular($default['type'])] = $default['path'];
        }

        return $data;
    }
}
