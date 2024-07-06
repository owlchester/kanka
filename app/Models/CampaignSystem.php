<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignSystem
 * @package App\Models
 *
 * @property int $campaign_id
 * @property int $user_id
 * @property string $text
 *
 * @property Campaign $campaign
 * @property User $user
 */
class CampaignSystem extends Pivot
{
    use HasCampaign;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameSystem()
    {
        return $this->belongsTo(GameSystem::class);
    }
}
