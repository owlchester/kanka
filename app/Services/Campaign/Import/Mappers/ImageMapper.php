<?php

namespace App\Services\Campaign\Import\Mappers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageMapper
{
    protected function image(string $field): void
    {
        if (empty($this->data[$field]) && ! empty($this->model->$field)) {
            return;
        }

        // Let's see if the original exists on the s3 bucket to avoid a lot of pain
        $destination = 'w/' . $this->campaign->id . '/' . Str::afterLast($this->data[$field], '/');
        if (Storage::exists($this->data['image'])) {
            Storage::copy($this->data['image'], $destination);
            $this->campaign->image = $destination;

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
