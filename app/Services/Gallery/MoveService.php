<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;

class MoveService
{
    use CampaignAware;

    /** @var array|Image[] */
    protected array $files;

    public function files(array $ids): self
    {
        $this->files = [];
        foreach ($ids as $id) {
            $image = Image::where('id', $id)->first();
            if (!$image) {
                continue;
            }
            $this->files[] = $image;
        }
        return $this;
    }

    public function move(?string $folderId): int
    {
        if (isset($folderId) && !empty($folderId)) {
            // Make sure it's a folder from the current campaign
            $folder = Image::where('id', $folderId)->where('is_folder', 1)->firstOrFail();
        }

        foreach ($this->files as $file) {
            // todo: prevent loops?
            $file->folder_id = $folderId;
            $file->save();
        }
        return count($this->files);
    }
}
