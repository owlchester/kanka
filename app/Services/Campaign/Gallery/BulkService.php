<?php

namespace App\Services\Campaign\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;

class BulkService
{
    use CampaignAware;

    protected array $files;

    public function files(array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function delete(): int
    {
        if (count($this->files) === 0) {
            return 0;
        }
        $count = Image::whereIn('id', $this->files)->delete();

        return $count;
    }
}
