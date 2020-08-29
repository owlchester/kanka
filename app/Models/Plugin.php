<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Plugin
 * @package App\Models
 *
 * @property int $id
 * @property int $type_id
 * @property int $status_id
 * @property string $name
 *
 * @property PluginVersion[] $versions
 */
class Plugin extends Model
{
    /**
     * @return string
     */
    public function type(): string
    {
        if ($this->type_id == 1) {
            return 'theme';
        } elseif ($this->type_id == 2) {
            return 'attribute';
        }
        return 'pack';
    }

    public function hasUpdate(): bool
    {
        // Check latest version
        return $this->versions()->where('status_id', 3)->where('id', '>', $this->pivot->plugin_version_id)->count() > 0;

        // Our current version
        //return $latest->id > $this->pivot->plugin_version_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions()
    {
        return $this->hasMany(PluginVersion::class);
    }
}
