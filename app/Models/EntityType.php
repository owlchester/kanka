<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * @param $query
     * @return mixed
     */
    public function scopeEnabled($query)
    {
        return $query
            ->where(['is_enabled' => true])
            ->orderBy('position');
    }

    /**
     * Get the class model of the entity type
     * @return mixed
     */
    public function getClass()
    {
        $className = 'App\Models\\' . camel_case($this->code);
        return app()->make($className);
    }

    /**
     * Get the translated name of the entity
     * @return string
     */
    public function name(): string
    {
        return trans('entities.' . $this->code);
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->name();
    }
}
