<?php


namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Plugin
 * @package App\Models
 *
 * @property int $id
 * @property string $uuid
 * @property int $type_id
 * @property int $status_id
 * @property string $name
 *
 * @property PluginVersion[] $versions
 * @property PluginVersion $version
 * @property User $user
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
        return $this->versions()->where(function ($sub) {
            if ($this->created_by == auth()->user()->id) {
                return $sub->whereIn('status_id', [1, 3]);
            } else {
                return $sub->where('status_id', 3);
            }

            })->where('id', '>', $this->pivot->plugin_version_id)->count() > 0;

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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return string
     */
    public function author(): string
    {
        if (!empty($this->user)) {
            if (!empty($this->user->settings['marketplace_name'])) {
                return e($this->user->settings['marketplace_name']);
            }
            return e($this->user->name);
        }

        return __('crud.users.unknown');
    }

}
