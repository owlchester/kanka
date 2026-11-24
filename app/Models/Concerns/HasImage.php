<?php

namespace App\Models\Concerns;

use App\Observers\ImageableObserver;
use App\Services\Images\Img;

/**
 * @property ?string image
 */
trait HasImage
{
    public static function bootHasImage(): void
    {
        $observer = app(ImageableObserver::class);
        static::saved([$observer, 'saved']);
        static::deleted([$observer, 'deleted']);
    }

    public function getImageFields(): array
    {
        return $this->imageFields ?? ['image'];
    }

    /**
     * Get the campaign's thumbnail url
     */
    public function thumbnail(int $width = 400, ?int $height = null, string $field = 'image'): string
    {
        if (empty($this->$field)) {
            return '';
        }

        return Img::for($this->$field)
            ->crop($width, (! empty($height) ? $height : $width))
            ->url();
    }
}
