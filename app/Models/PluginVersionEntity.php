<?php

namespace App\Models;

use App\Facades\Img;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PluginVersionEntity
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $plugin_version_id
 * @property int $type_id
 * @property string $image_path
 * @property string $entry
 * @property array $fields
 * @property array $related
 * @property string $uuid
 *
 * @property EntityType $type
 * @property PluginVersion $version
 */
class PluginVersionEntity extends Model
{
    public $casts = [
        'fields' => 'array',
        'related' => 'array',
    ];

    public function version()
    {
        return $this->belongsTo(PluginVersion::class, 'plugin_version_id');
    }

    public function type()
    {
        return $this->belongsTo(EntityType::class, 'type_id');
    }
}
