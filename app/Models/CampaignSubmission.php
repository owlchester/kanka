<?php


namespace App\Models;


use App\Traits\CampaignTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignSubmission
 * @package App\Models
 *
 * @property int $campaign_id
 * @property int $user_id
 * @property string $text
 *
 * @property Campaign $campaign
 * @property User $user
 */
class CampaignSubmission extends Model
{
    use CampaignTrait;

    public $fillable = [
        'text',
    ];

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
