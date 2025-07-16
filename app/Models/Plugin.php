<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class Plugin
 *
 * @property int $id
 * @property string $uuid
 * @property int $type_id
 * @property int $status_id
 * @property ?int $created_by
 * @property string $name
 * @property bool|int $is_obsolete
 * @property PluginVersion[]|Collection $versions
 * @property PluginVersion $version
 *
 * @method static self|Builder highlighted(string $uuid)
 */
class Plugin extends Model
{
    use HasUser;
    use SoftDeletes;
    use SortableTrait;

    protected string $userField = 'created_by';

    protected ?PluginVersion $cachedHasUpdate;

    public $sortable = [
        'name',
        'type_id',
        'pivot_is_active',
        'has_update',
    ];

    public function type(): string
    {
        if ($this->type_id == 1) {
            return 'theme';
        } elseif ($this->type_id == 2) {
            return 'attribute';
        }

        return 'pack';
    }

    public function hasUpdate(bool $withDraft = false): bool
    {
        if (isset($this->cachedHasUpdate)) {
            return !empty($this->cachedHasUpdate);
        }

        $statuses = [3];
        if ($withDraft) {
            $statuses[] = 1;
        }

        $this->cachedHasUpdate = $this
            ->versions
            ->whereIn('status_id', $statuses)
            ->where('id', '>', $this->pivot->plugin_version_id) // @phpstan-ignore-line
            ->last();

        return !empty($this->cachedHasUpdate);
    }

    public function updateVersionNumber(): string
    {
        return $this->cachedHasUpdate->version ?? '0.0.0';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\PluginVersion, $this>
     */
    public function versions(): HasMany
    {
        return $this->hasMany(PluginVersion::class);
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
                DB::raw($update),
            ]);
    }

    public function author(): string
    {
        if (empty($this->user)) {
            return __('crud.users.unknown');
        }
        if (! empty($this->user->settings['marketplace_name'])) {
            return e($this->user->settings['marketplace_name']);
        }

        return e($this->user->name);
    }

    public function isContentPack(): bool
    {
        return $this->type_id == PluginType::TYPE_PACK;
    }

    public function isTheme(): bool
    {
        return $this->type_id == PluginType::TYPE_THEME;
    }

    public function isAttributeTemplate(): bool
    {
        return $this->type_id == PluginType::TYPE_ATTRIBUTE;
    }

    public function scopeHighlighted(Builder $query, ?string $uuid = null): Builder
    {
        if (empty($uuid) || ! Str::isUuid($uuid)) {
            return $query;
        }

        return $query->orderByRaw(
            $this->getTable() . '.uuid = ? DESC',
            [$uuid]
        );
    }

    public function url(string $sub): string
    {
        return 'campaign_plugins.' . $sub;
    }

    public function libraryUrl(): string
    {
        return config('marketplace.url') . '/plugins/' . $this->uuid;
    }

    /**
     * Determine if the plugin is obsolete
     */
    public function obsolete(): bool
    {
        return $this->is_obsolete;
    }
}
