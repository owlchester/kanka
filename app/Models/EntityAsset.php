<?php

namespace App\Models;

use App\Facades\EntityAssetCache;
use App\Facades\Img;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasSuggestions;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Sanitizable;
use App\Models\Scopes\EntityAssetScopes;
use App\Models\Scopes\Pinnable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $type_id
 * @property int $entity_id
 * @property ?string $image_uuid
 * @property string $name
 * @property array $metadata
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Entity $entity
 * @property ?Image $image
 */
class EntityAsset extends Model
{
    use Blameable;
    use EntityAssetScopes;
    use HasFactory;
    use HasSuggestions;
    use HasVisibility;
    use Pinnable;
    use Sanitizable;

    public const int TYPE_FILE = 1;

    public const int TYPE_LINK = 2;

    public const int TYPE_ALIAS = 3;

    public $fillable = [
        'type_id',
        'entity_id',
        'name',
        'metadata',
        'visibility_id',
        'is_pinned',
        'image_uuid',
    ];

    public $casts = [
        'metadata' => 'array',
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $sanitizable = [
        'name',
        'metadata.icon',
        'metadata.url',
    ];

    protected array $suggestions = [
        EntityAssetCache::class => 'clearSuggestion',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Image, $this>
     */
    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'id', 'image_uuid');
    }

    /**
     * Determine if the asset is a file
     */
    public function isFile(): bool
    {
        return $this->type_id == self::TYPE_FILE;
    }

    /**
     * Determine if the asset is a link
     */
    public function isLink(): bool
    {
        return $this->type_id == self::TYPE_LINK;
    }

    /**
     * Determine if the asset is an alias
     */
    public function isAlias(): bool
    {
        return $this->type_id == self::TYPE_ALIAS;
    }

    /**
     * Determine if the file is an image
     */
    public function isImage(): bool
    {
        return $this->isFile() && Str::startsWith($this->metadata['type'], 'image/');
    }

    /**
     * Get the image's url
     */
    public function imageUrl(): string
    {
        if ($this->image) {
            return $this->image->getUrl(128, 80);
        }

        return Img::crop(128, 80)->url($this->metadata['path']);
    }

    /**
     * Get the fontawesome custom icon
     */
    public function icon(): string
    {
        if (empty($this->metadata['icon'])) {
            return 'fa-regular fa-link';
        }

        return (string) $this->metadata['icon'];
    }

    public function previewIcon(): string
    {
        if (! $this->image) {
            return 'fa-regular fa-file';
        }

        return match ($this->image->ext) {
            'pdf' => 'fa-regular fa-file-pdf',
            'json' => 'fa-regular fa-brackets-curly',
            'mp3', 'mp4', 'ogg' => 'fa-regular fa-file-music',
            'xls', 'xlsx' => 'fa-regular fa-file-xls',
            'csv' => 'fa-regular fa-file-csv',
            default => 'fa-regular fa-file',
        };
    }

    public function getIconAttribute(): mixed
    {
        return Arr::get($this->metadata, 'icon');
    }

    /**
     * A virtual getter for the image path for the image observer delete loop
     */
    public function getImagePathAttribute(): string
    {
        if ($this->image && ! $this->image->isUsed()) {
            return (string) $this->image->path;
        }

        return (string) $this->metadata['path'];
    }

    /**
     * Copy the asset to another target
     */
    public function copyTo(Entity $target): bool
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;

        return $new->save();
    }

    /**
     * Get the url's domain (skip the rest)
     */
    public function urlDomain(): string
    {
        $url = $this->metadata['url'];
        try {
            $params = parse_url($url);

            return $params['host'];
        } catch (Exception $e) {
            return '';
        }
    }

    public function url(): string
    {
        if ($this->image_uuid) {
            return $this->image?->url() ?? '';
        }

        $path = $this->metadata['path'];
        $cdn = config('cdn.ugc');
        if ($cdn) {
            return $cdn . '/' . $path;
        }

        return Storage::url($path);
    }

    /**
     * A file can be linked to a gallery image, but the target image is hidden from the current user.
     */
    public function hiddenImage(): bool
    {
        return ! empty($this->image_uuid) && ! $this->image;
    }
}
