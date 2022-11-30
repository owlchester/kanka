<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class Plugin
 * @package App\Models
 *
 * @property int $id
 * @property string $uuid
 * @property int $type_id
 * @property int $status_id
 * @property int $created_by
 * @property string $name
 * @property bool $is_obsolete
 *
 * @property PluginVersion[]|Collection $versions
 * @property PluginVersion $version
 * @property User|null $user
 *
 * @method static self|Builder highlighted(string $uuid)
 */
class Plugin extends Model
{
    use SoftDeletes, SortableTrait;

    protected $cachedHasUpdate = null;

    public $sortable = [
        'name',
        'type_id',
        'pivot_is_active',
        'has_update'
    ];

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

    /**
     * @return bool
     */
    public function hasUpdate(): bool
    {
        if ($this->cachedHasUpdate !== null) {
            return $this->cachedHasUpdate;
        }

        $statuses = [3];
        if ($this->created_by === auth()->user()->id) {
            $statuses[] = 1;
        }
        return $this->cachedHasUpdate = $this
                ->versions
                ->whereIn('status_id', $statuses)
                ->where('id', '>', $this->pivot->plugin_version_id) // @phpstan-ignore-line
                ->count() > 0;
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

    public function scopePreparedSelect(Builder $builder): Builder
    {
        $update = 'null';
        if (auth()->check()) {
            $update = 'CASE WHEN (
                    SELECT upd.id
                    FROM plugin_versions AS upd
                    WHERE upd.plugin_id = ' . $this->getTable() . '.id AND
                    (upd.status_id = 3 OR (upd.status_id in (1,3) AND ' . $this->getTable() . '.created_by = ' . auth()->user()->id . ')) AND
                    upd.id > campaign_plugins.plugin_version_id
                    LIMIT 1
                ) IS NOT NULL THEN 1 ELSE 0 END AS has_update';
        }

        return $builder
            ->distinct()
            ->select([
                $this->getTable() . '.*',
                DB::raw($update)
            ])
        ;
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

    /**
     * @return bool
     */
    public function isContentPack(): bool
    {
        return $this->type_id == PluginType::TYPE_PACK;
    }

    /**
     * @return bool
     */
    public function isTheme(): bool
    {
        return $this->type_id == PluginType::TYPE_THEME;
    }

    /**
     * @return bool
     */
    public function isAttributeTemplate(): bool
    {
        return $this->type_id == PluginType::TYPE_ATTRIBUTE;
    }

    /**
     * @param Builder $query
     * @param string|null $uuid
     * @return Builder
     */
    public function scopeHighlighted(Builder $query, string $uuid = null)
    {
        if (empty($uuid) || !Str::isUuid($uuid)) {
            return $query;
        }

        return $query->orderByRaw(
            DB::raw($this->getTable() . ".uuid = '$uuid' DESC")
        );
    }
    /**
     * @param string $sub
     * @return string
     */
    public function url(string $sub): string
    {
        return 'campaign_plugins.' . $sub;
    }

    /**
     * Determine if the plugin is obsolete
     * @return bool
     */
    public function obsolete(): bool
    {
        return $this->is_obsolete;
    }
}
