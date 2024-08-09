<?php

namespace App\Models\Concerns;

use App\Facades\Img;
use App\Observers\ImageableObserver;

/**
 * @property ?string image
 */
trait HasImage
{
    public static function bootHasImage(): void
    {
        static::observe(ImageableObserver::class);
    }

    public function getImageFields(): array
    {
        return $this->imageFields ?? ['image'];
    }

    /**
     * Get the campaign's thumbnail url
     */
    public function thumbnail(int $width = 400, int $height = null, string $field = 'image'): string
    {
        if (empty($this->$field)) {
            return '';
        }
        return Img::resetCrop()
            ->crop($width, (!empty($height) ? $height : $width))
            ->url($this->$field);
    }

}
