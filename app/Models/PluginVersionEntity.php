<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PluginVersionEntity
 *
 * @property int $id
 * @property string $name
 * @property int $plugin_version_id
 * @property int $type_id
 * @property string $image_path
 * @property string $entry
 * @property array $fields
 * @property array $related
 * @property array $posts
 * @property string $uuid
 * @property EntityType $type
 * @property PluginVersion $version
 */
class PluginVersionEntity extends Model
{
    public $casts = [
        'fields' => 'array',
        'related' => 'array',
        'posts' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\PluginVersion, $this>
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(PluginVersion::class, 'plugin_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\EntityType, $this>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'type_id');
    }
}
