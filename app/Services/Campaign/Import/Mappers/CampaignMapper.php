<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Campaign;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignMapper
{
    use CampaignAware;
    use ImportMapper;

    public function import(): Campaign
    {
        // Fields that are fillable but that we don't want to import automatically
        $forbidden = ['slug', 'name', 'image', 'export_date', 'visibility_id'];
        $fillable = $this->campaign->getFillable();
        foreach ($this->data as $property => $value) {
            if (in_array($property, $forbidden) && ! empty($this->campaign->$property)) {
                continue;
            }
            if (! is_array($value)) {
                if (! in_array($property, $fillable)) {
                    continue;
                }
                $this->campaign->$property = $value;
            }
        }

        $this->image('image');
        $this->image('header_image');

        $arrays = ['settings', 'default_images', 'ui_settings'];
        foreach ($arrays as $key) {
            if (empty($this->data[$key])) {
                continue;
            }
            $this->campaign->$key = $this->data[$key];
        }

        $this->campaign->save();

        return $this->campaign;
    }

    protected function image(string $field): void
    {
        if (empty($this->data[$field]) || empty($this->campaign->$field)) {
            return;
        }

        // Let's see if the original exists on the s3 bucket to avoid a lot of pain
        $destination = 'w/' . $this->campaign->id . '/' . Str::afterLast($this->data[$field], '/');
        if (Storage::exists($this->data[$field])) {
            Storage::copy($this->data[$field], $destination);
            $this->campaign->$field = $destination;

            return;
        }

        $path = $this->path . '/' . $this->data[$field];
        if (! Storage::disk('local')->exists($path)) {
            return;
        }

        // Upload the file to s3 using streams
        Storage::writeStream($destination, Storage::disk('local')->readStream($path));
        $this->campaign->$field = $destination;
    }
}
