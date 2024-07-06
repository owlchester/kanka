<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignSubmission
 * @package App\Models
 *
 * @property int $user_id
 * @property string $text
 *
 * @property User $user
 */
class CampaignSubmission extends Model
{
    use HasCampaign;

    public $fillable = [
        'text',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
