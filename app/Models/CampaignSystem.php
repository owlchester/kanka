<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignSystem
 * @package App\Models
 *
 * @property int $user_id
 * @property string $text
 */
class CampaignSystem extends Pivot
{
    use HasCampaign;

    public function gameSystem(): BelongsTo
    {
        return $this->belongsTo(GameSystem::class);
    }
}
