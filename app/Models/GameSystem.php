<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class GameSystem extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignSystem, $this>
     */
    public function campaignSystem(): HasMany
    {
        return $this->hasMany(CampaignSystem::class, 'system_id', 'id');
    }
}
