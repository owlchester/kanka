<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class FeatureCategory extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Feature, $this>
     */
    public function features(): HasMany
    {
        return $this->hasMany(Feature::class, 'category_id', 'id');
    }

    public function progress(): HasMany
    {
        return $this->features()
            ->whereIn('features.status_id', [
                \App\Enums\FeatureStatus::Later, \App\Enums\FeatureStatus::Next, \App\Enums\FeatureStatus::Now,
            ]);
    }

    public function done(): HasMany
    {
        return $this->features()->where('status_id', \App\Enums\FeatureStatus::Done)->orderBy('updated_at', 'DESC');
    }

    public function now(): HasMany
    {
        return $this->features()->where('status_id', \App\Enums\FeatureStatus::Now);
    }

    public function next(): HasMany
    {
        return $this->features()->where('status_id', \App\Enums\FeatureStatus::Next);
    }

    public function later(): HasMany
    {
        return $this->features()->where('status_id', \App\Enums\FeatureStatus::Later);
    }

    public function nothingPlanned(): bool
    {
        return $this->now->count() + $this->later->count() + $this->next->count() === 0;
    }

    public function nothingDone(): bool
    {
        return $this->done->count() === 0;
    }
}
