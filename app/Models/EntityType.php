<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Facades\Module;

/**
 * @property int $id
 * @property string $code
 * @property AttributeTemplates[]|Collection $attributeTemplates
 *
 * @method static self|Builder exclude(array $ids)
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
        return Module::singular($this->id, __('entities.' . $this->code));
    }

    /**
     * Get the translated name of the entity
     */
    public function plural(): string
    {
        return Module::plural($this->id, __('entities.' . $this->pluralCode()));
    }

    /**
     * Get the translated name of the entity
     */
    public function icon(): string
    {
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
}
