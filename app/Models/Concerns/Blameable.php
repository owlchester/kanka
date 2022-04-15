<?php

namespace App\Models\Concerns;

use App\Observers\BlameableObserver;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait Blameable
 * @package App\Models\Concerns
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 *
 * @property User $creator
 * @property User $updater
 */
trait Blameable
{
    /**
     * Get any of override 'blameable attributes'.
     *
     * @return array
     */
    public function blameable() :array
    {
        if (property_exists($this, 'blameable')) {
            return (array) static::$blameable;
        }
        return [];
    }

    /**
     * Boot the trait's observers
     */
    public static function bootBlameable(): void
    {
        static::observe(app(BlameableObserver::class));
    }

    /**
     * Register events we need to listen for.
     *
     * @return void
     */
    public static function registerListeners()
    {
        static::creating('App\Listeners\Blameable\Creating@handle');
        static::updating('App\Listeners\Blameable\Updating@handle');
        /*if (static::usingSoftDeletes()) {
            static::deleting('App\Listeners\Deleting@handle');
            static::restoring('App\Listeners\Restoring@handle');
        }*/
    }

    /**
     * Get the user who created this model
     * @return mixed
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Get the user who updated this model
     * @return mixed
     */
    public function updater()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    /**
     *
     * @return mixed
     */
    public function remover()
    {
        return $this->belongsTo('App\User', 'deleted_by');
    }


    /**
     * createdBy Query Scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed                                 $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedBy(Builder $query, $userId) :Builder
    {
        if ($userId instanceof Model) {
            $userId = $userId->getKey();
        }
        return $query->where(['created_by' => $userId]);
    }

    /**
     * updatedBy Query Scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed                                 $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpdatedBy(Builder $query, $userId) :Builder
    {
        if ($userId instanceof Model) {
            $userId = $userId->getKey();
        }
        return $query->where(['updated_by' => $userId]);
    }
}
