<?php


namespace App\Models;


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
 * @property string $name
 *
 * @property PluginVersion[]|Collection $versions
 * @property PluginVersion $version
 * @property User $user
 *
 * @method static|Builder highlighted(string $uuid)
 */
class Plugin extends Model
{
    use SoftDeletes;

    protected $cachedHasUpdate = null;

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
                ->where('id', '>', $this->pivot->plugin_version_id)
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
     * @param $query
     * @param string|null $highlighted
     * @return mixed
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
}
