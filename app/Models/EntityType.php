<?php

namespace App\Models;

use App\Models\Concerns\Sanitizable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Facades\Module;

/**
 * @property int $id
 * @property string $code
 * @property int $campaign_id
 * @property Campaign $campaign
 * @property ?string $singular
 * @property ?string $plural
 * @property ?string $icon
 * @property bool|int $is_special
 * @property bool|int $is_enabled
 * @property AttributeTemplates[]|Collection $attributeTemplates
 * @property Bookmark[]|Collection $bookmarks
 * @property Entity[]|Collection $entities
 * @property CampaignDashboardWidget[]|Collection $widgets
 *
 * @method static self|Builder enabled()
 * @method static self|Builder default()
 * @method static self|Builder exclude(array $ids)
 * @method static self|Builder inCampaign(Campaign|int $campaign)
 */
class EntityType extends Model
{
    use Sanitizable;

    protected array $sanitizable = ['singular', 'plural'];

    protected string $cachedPluralCode;

    public $fillable = [
        'id',
        'code',
        'position',
        'is_enabled',
        'is_special',
    ];

    public function scopeInCampaign(Builder $query, Campaign|int $campaign): Builder
    {
        if ($campaign instanceof Campaign) {
            $campaign = $campaign->id;
        }
        return $query->where(function ($sub) use ($campaign) {
            return $sub->where('campaign_id', $campaign)
                ->orWhereNull('campaign_id');
        });
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->whereNull('campaign_id');
    }

    /**
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query
            ->where(['is_enabled' => true])
            ->orderBy('position');
    }

    public function scopeExclude(Builder $query, array $exclude): Builder
    {
        return $query->whereNotIn('id', $exclude);
    }

    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'type_id');
    }

    public function attributeTemplates(): HasMany
    {
        return $this->hasMany(AttributeTemplate::class, 'entity_type_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class, 'entity_type_id');
    }

    public function widgets(): HasMany
    {
        return $this->hasMany(CampaignDashboardWidget::class, 'entity_type_id');
    }

    /**
     * Get the class model of the entity type
     */
    public function getClass(): MiscModel|Model
    {
        $className = 'App\Models\\' . Str::studly($this->code);
        return app()->make($className);
    }

    /**
     * Get the translated name of the entity
     */
    public function name(): string
    {
        if (!empty($this->singular)) {
            return $this->singular;
        }
        return Module::singular($this->id, __('entities.' . $this->code));
    }

    /**
     * Get the translated name of the entity
     */
    public function plural(): string
    {
        if (!empty($this->plural)) {
            return $this->plural;
        }
        return Module::plural($this->id, __('entities.' . $this->pluralCode()));
    }

    /**
     * Get the translated name of the entity
     */
    public function icon(): string
    {
        if (!empty($this->icon)) {
            return $this->icon;
        }
        return Module::duoIcon($this->code);
    }

    /**
     * Get the translated name of the entity
     */
    public function pluralCode(): string
    {
        if (isset($this->cachedPluralCode)) {
            return $this->cachedPluralCode;
        }
        return $this->cachedPluralCode = Str::plural($this->code);
    }

    /**
     */
    public function getNameAttribute(): string
    {
        return $this->name();
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function isSpecial(): bool
    {
        return (bool) $this->is_special;
    }

    public function isEnabled(): bool
    {
        return (bool) $this->is_enabled;
    }

    public function createRoute(Campaign $campaign, array $params = []): string
    {
        if ($this->isSpecial()) {
            return route('entities.create', [$campaign, $this] + $params);
        }
        return route($this->pluralCode() . '.create', [$campaign] + $params);
    }

    public function isDeprecated(): bool
    {
        return in_array($this->id, [config('entities.ids.conversation'), config('entities.ids.dice_roll')]);
    }
}
