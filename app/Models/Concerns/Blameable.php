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
     * Boot the trait's observers
     */
    public static function bootBlameable(): void
    {
        static::observe(app(BlameableObserver::class));
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
    public function scopeCreatedBy(Builder $query, $userId): Builder
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
    public function scopeUpdatedBy(Builder $query, $userId): Builder
    {
        if ($userId instanceof Model) {
            $userId = $userId->getKey();
        }
        return $query->where(['updated_by' => $userId]);
    }
}
