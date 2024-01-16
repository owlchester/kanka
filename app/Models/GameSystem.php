<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSystem extends Model
{
    public function campaignSystem()
    {
        return $this->hasMany(CampaignSystem::class, 'system_id', 'id');
    }
}
