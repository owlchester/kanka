<?php

namespace App\Models;

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
 * @property string $singular
 * @property string $plural
 * @property string $icon
 * @property bool $is_special
 * @property bool $is_enabled
 * @property AttributeTemplates[]|Collection $attributeTemplates
 *
 * @method static self|Builder enabled()
 * @method static self|Builder exclude(array $ids)
 * @method static self|Builder inCampaign(Campaign $campaign)
 */
class EntityType extends Model
{
    protected string $cachedPluralCode;

    public $fillable = [
        'id',
        'code',
        'position',
        'is_enabled',
        'is_special',
    ];

    public function scopeInCampaign(Builder $query, Campaign $campaign): Builder
    {
        return $query->where(function ($sub) use ($campaign) {
            return $sub->where('campaign_id', $campaign->id)->orWhereNull('campaign_id');
        });
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

    public function attributeTemplates(): HasMany
    {
        return $this->hasMany(AttributeTemplate::class, 'entity_type_id');
    }

    /**
     * Get the class model of the entity type
     */
    public function getClass(): Model
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
        return $this->is_special;
    }

    public function isEnabled(): bool
    {
        return $this->is_enabled;
    }
}
