<?php

namespace App\Models\Concerns;

use App\Observers\BlameableObserver;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Trait Blameable
 * @package App\Models\Concerns
 * @property ?int $created_by
 * @property ?int $updated_by
 * @property ?int $deleted_by
 *
 * @property ?User $creator
 * @property ?User $updater
 * @property ?User $remover
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
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated this model
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted this model
     */
    public function remover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }


    /**
     *
     */
    public function scopeCreatedBy(Builder $query, $userId): Builder
    {
        if ($userId instanceof Model) {
            $userId = $userId->getKey();
        }
        return $query->where(['created_by' => $userId]);
    }

    /**
     *
     */
    public function scopeUpdatedBy(Builder $query, $userId): Builder
    {
        if ($userId instanceof Model) {
            $userId = $userId->getKey();
        }
        return $query->where(['updated_by' => $userId]);
    }


    /**
     * Check if the current model uses SoftDeletes.
     */
    public function useSoftDeletes(): bool
    {
        return in_array(SoftDeletes::class, class_uses_recursive($this), true);
    }
}
