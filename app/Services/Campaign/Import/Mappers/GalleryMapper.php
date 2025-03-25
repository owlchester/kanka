<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Image;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GalleryMapper
{
    use CampaignAware;
    use ImportMapper;

    protected array $mapping = [];

    protected array $parents = [];

    protected Image $image;

    protected array $reset = ['created_at', 'updated_at', 'created_by', 'campaign_id', 'id', 'folder_id', 'image_folder'];

    public function has(string $uuid): bool
    {
        return ! empty($this->mapping[$uuid]);
    }

    public function get(string $uuid): string
    {
        return $this->mapping[$uuid];
    }

    public function mapping(): array
    {
        return $this->mapping;
    }

    public function prepare(): self
    {
        // $this->campaign->images()->delete();
        return $this;
    }

    public function import(): void
    {
        $this->image = new Image;
        $this->image->campaign_id = $this->campaign->id;
        // Need to save to set the id otherwise it stores wrong data.
        $this->image->save();
        $this->mapping[$this->data['id']] = $this->image->id;
        ImportIdMapper::putGallery($this->data['id'], $this->image->id);

        if (! empty($this->data['folder_id'])) {
            $this->parents[$this->data['folder_id']][] = $this->image->id;
        }

        $this->importFields();
        $this->image->save();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (empty($this->mapping[$parent])) {
                continue;
            }

            $newParent = $this->mapping[$parent];
            DB::update('UPDATE images SET folder_id = \'' . $newParent . '\' where id in (\'' . implode('\', \'', $children) . '\') limit ' . count($children));
        }

        return $this;
    }

    protected function importFields(): void
    {
        foreach ($this->data as $field => $value) {
            if (in_array($field, $this->reset)) {
                continue;
            }
            $this->image->$field = $value;
        }

        $this->importImage();
    }

    protected function importImage(): void
    {
        if ($this->data['is_folder'] === 1) {
            return;
        }
        // An image needs the image saved locally
        $imagePath = $this->path . '/' . $this->data['id'] . '.' . $this->data['ext'];
        $destination = 'campaigns/' . $this->campaign->id . '/' . $this->image->id . '.' . $this->data['ext'];

        if (! Storage::disk('local')->exists($imagePath)) {
            Log::info('image ' . $imagePath . ' doesnt exist');

            return;
        }

        // Upload the file to s3 using streams
        Storage::writeStream($destination, Storage::disk('local')->readStream($imagePath));
    }
}
