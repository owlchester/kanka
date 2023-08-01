<?php

namespace App\Models;

use App\Facades\Img;
use App\Models\Concerns\Blameable;
use App\Models\Scopes\EntityAssetScopes;
use App\Models\Scopes\Pinnable;
use App\Traits\VisibilityIDTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $type_id
 * @property int $entity_id
 * @property string $name
 * @property array $metadata
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Entity|null $entity
 * @property bool $is_pinned
 *
 */
class EntityAsset extends Model
{
    use Blameable;
    use EntityAssetScopes;
    use Pinnable;
    use VisibilityIDTrait;
    public const TYPE_FILE = 1;
    public const TYPE_LINK = 2;
    public const TYPE_ALIAS = 3;

    public $fillable = [
        'type_id',
        'entity_id',
        'name',
        'metadata',
        'visibility_id',
        'is_pinned',
    ];

    public $casts = [
        'metadata' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Determine if the asset is a file
     * @return bool
     */
    public function isFile(): bool
    {
        return $this->type_id == self::TYPE_FILE;
    }

    /**
     * Determine if the asset is a link
     * @return bool
     */
    public function isLink(): bool
    {
        return $this->type_id == self::TYPE_LINK;
    }

    /**
     * Determine if the asset is an alias
     * @return bool
     */
    public function isAlias(): bool
    {
        return $this->type_id == self::TYPE_ALIAS;
    }

    /**
     * Determine if the file is an image
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->isFile() && Str::startsWith($this->metadata['type'], 'image/');
    }

    /**
     * Get the image's url
     * @return string
     */
    public function imageUrl(): string
    {
        return Img::crop(120, 80)->url($this->metadata['path']);
    }

    /**
     * Get the fontawesome custom icon
     * @return string
     */
    public function icon(): string
    {
        if (empty($this->metadata['icon'])) {
            return 'fa-solid fa-link';
        }
        return (string) $this->metadata['icon'];
    }

    public function getIconAttribute(): mixed
    {
        return Arr::get($this->metadata, 'icon');
    }

    /**
     * A virtual getter for the image path for the image observer delete loop
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        return (string) $this->metadata['path'];
    }

    /**
     * Copy the asset to another target
     * @param Entity $target
     * @return bool
     */
    public function copyTo(Entity $target): bool
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }

    /**
     * Get the url's domain (skip the rest)
     * @return string
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
}
