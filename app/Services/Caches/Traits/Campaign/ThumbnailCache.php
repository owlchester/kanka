<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Str;

trait ThumbnailCache
{
    /**
     * Default Entity Images for a campaign
     * @return array
     */
    public function defaultImages(): array
    {
        $data = $this->primary()->get('thumbnails', null);
        // Since thumbnails come from the db, we need to load them _after_ permissions/campaign roles have been loaded.
        // It's an extra back and forth with redis on the first init of a clear cache
        if (is_array($data)) {
            return $data;
        }

        return $this->append('thumbnails', $this->formatThumbnails());
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