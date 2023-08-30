<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Facades\Module;

/**
 * @property int $id
 * @property string $code
 */
class EntityType extends Model
{
    public $fillable = [
        'id',
        'code',
        'position',
        'is_enabled',
        'is_special',
    ];

    /**
     */
    public function scopeEnabled(Builder $query)
    {
        return $query
            ->where(['is_enabled' => true])
            ->orderBy('position');
    }

    /**
     * Get the class model of the entity type
     */
    public function getClass()
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
     */
    public function getNameAttribute(): string
    {
        return $this->name();
    }
}
