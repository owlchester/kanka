<?php

namespace App\Services\Gallery;

use App\Exceptions\TranslatableException;
use App\Http\Resources\GalleryFile;
use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use App\Sanitizers\SvgAllowedAttributes;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReplaceService
{
    use CampaignAware;
    use UserAware;

    protected StorageService $storage;

    public function __construct(StorageService $storageService)
    {
        $this->storage = $storageService;
    }

    public function replace(Image $image, UploadedFile $file): GalleryFile
    {
        $newKb = (int) ceil($file->getSize() / 1024);
        $deltaKb = max(0, $newKb - (int) $image->size);
        $available = $this->storage->campaign($this->campaign)->available();

        if (! $this->storage->campaign($this->campaign)->isUnlimited() && $deltaKb > $available) {
            throw new TranslatableException(
                $this->campaign->boosted()
                    ? 'gallery.download.errors.gallery_full_premium'
                    : 'gallery.download.errors.gallery_full_free'
            );
        }

        $oldPath = $image->path;
        $oldTilesPath = $image->tilesPath();
        $wasTiled = $image->isTiled() || $image->tilingRunning();

        $ext = Str::lower(Str::before($file->extension(), '?'));
        if ($ext === 'svg' || Str::lower($file->getClientOriginalExtension()) === 'svg') {
            $ext = 'svg';
        }

        $image->version = ($image->version ?? 0) + 1;
        $image->ext = $ext;
        $image->size = $newKb;

        $metadata = $image->metadata ?? [];
        unset($metadata['width'], $metadata['height'], $metadata['tile_min_zoom'], $metadata['tile_max_zoom']);
        $image->metadata = $metadata;
        $image->tiling_status = null;
        $image->tiling_error = null;
        $image->save();

        if ($image->isSvg()) {
            $sanitizer = new Sanitizer;
            $sanitizer->setAllowedAttrs(new SvgAllowedAttributes);
            $cleanSvg = $sanitizer->sanitize((string) file_get_contents($file->getRealPath()));
            Storage::put($image->path, $cleanSvg, 'public');
        } else {
            $file->storePubliclyAs($image->folder, $image->file);
        }

        $image->ensureDimensions();

        if ($oldPath !== $image->path && Storage::disk()->exists($oldPath)) {
            Storage::disk()->delete($oldPath);
        }

        if ($wasTiled) {
            Storage::disk()->deleteDirectory($oldTilesPath);
            if ($image->mapLayers()->exists() || Map::whereHas('entity', fn ($q) => $q->where('image_uuid', $image->id))->exists()) {
                TileImageJob::dispatch($image);
            }
        }

        $this->storage->campaign($this->campaign)->clearCache();

        return (new GalleryFile($image->fresh(['creator'])))->campaign($this->campaign);
    }
}
