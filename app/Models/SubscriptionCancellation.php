<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SubscriptionCancellation
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $reason
 * @property string $custom
 * @property string $tier
 * @property string $duration
 * @property Carbon $created_at
 */
class SubscriptionCancellation extends Model
{
    /**
     * @var string
     */
    public $table = 'subscription_cancellations';

    protected $fillable = [
        'user_id',
        'reason',
        'custom',
        'tier',
        'duration',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
