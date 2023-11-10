<?php

namespace App\Services\Campaign\Import;

trait GalleryAware
{
    protected array $galleryMapping;

    public function galleryMapping(array $mappings): self
    {
        $this->galleryMapping = $mappings;
        return $this;
    }

    public function mapGallery(string $uuid): string
    {
        return $this->galleryMapping[$uuid];
    }
}
