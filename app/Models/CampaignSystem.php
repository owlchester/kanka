<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignSystem
 *
 * @property int $user_id
 * @property string $text
 */
class CampaignSystem extends Pivot
{
    use HasCampaign;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\GameSystem, $this>
     */
    public function gameSystem(): BelongsTo
    {
        return $this->belongsTo(GameSystem::class);
    }
}
