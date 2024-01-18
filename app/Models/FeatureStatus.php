<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class FeatureStatus extends Model
{
    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }
}
