<?php

namespace App\Models;

use App\Traits\CampaignTrait;
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
    use CampaignTrait;

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
