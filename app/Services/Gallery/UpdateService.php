<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;
use Illuminate\Support\Arr;

class UpdateService
{
    use CampaignAware;

    /** @var array|Image[] */
    protected array $files;

    public function files(array $ids): self
    {
        $this->files = [];
        foreach ($ids as $id) {
            $image = Image::where('id', $id)->first();
            if (! $image) {
                continue;
            }
            $this->files[] = $image;
        }

        return $this;
    }

    public function update(array $data): int
    {
        $folderId = Arr::get($data, 'folder_id');
        $home = Arr::get($data, 'folder_home');
        $visibilityId = Arr::get($data, 'visibility_id');

        if (! empty($folderId)) {
            // Make sure it's a folder from the current campaign
            $folder = Image::where('id', $folderId)->where('is_folder', 1)->firstOrFail();
        }

        foreach ($this->files as $file) {
            // todo: prevent loops?
            if (isset($folder)) {
                $file->folder_id = $folder->id;
            } elseif (! empty($home)) {
                $file->folder_id = null;
            }
            if (! empty($visibilityId)) {
                $file->visibility_id = $visibilityId;
            }
            $file->save();
        }

        return count($this->files);
    }
}
