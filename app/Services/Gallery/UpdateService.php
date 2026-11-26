<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class UpdateService
{
    use CampaignAware;
    use UserAware;

    /** @var array<int, Image> */
    protected array $files = [];

    public function files(array $ids): self
    {
        $this->files = [];
        $images = Image::where('campaign_id', $this->campaign->id)
            ->whereIn('id', $ids)
            ->get();

        foreach ($images as $image) {
            if ($this->user && ! $this->user->can('edit', [$image, $this->campaign])) {
                abort(403);
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

        $folder = null;
        if (! empty($folderId)) {
            $folder = Image::where('id', $folderId)
                ->where('campaign_id', $this->campaign->id)
                ->where('is_folder', true)
                ->firstOrFail();
        }

        foreach ($this->files as $file) {
            if ($folder) {
                if ($file->isFolder() && ($folder->id === $file->id || $folder->isDescendantOf($file->id))) {
                    throw ValidationException::withMessages([
                        'folder_id' => __('gallery.update.errors.folder_cycle'),
                    ]);
                }
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
