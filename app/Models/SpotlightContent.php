<?php

namespace App\Models;

use App\Enums\SpotlightContentStatus;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property SpotlightContentStatus $status
 * @property string $content_json
 */
class SpotlightContent extends Model
{
    use Blameable;
    use HasCampaign;
    use HasTimestamps;

    public $casts = [
        'status' => SpotlightContentStatus::class,
        'content_json' => 'json',
    ];

    public function isDraft(): bool
    {
        return $this->status === SpotlightContentStatus::draft;
    }

    public function isApplied(): bool
    {
        return $this->status === SpotlightContentStatus::applied;
    }

    public function isRejected(): bool
    {
        return $this->status === SpotlightContentStatus::rejected;
    }

    public function isApproved(): bool
    {
        return $this->status === SpotlightContentStatus::approved;
    }
}
