<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriptionCancellation
 * @package App\Models
 *
 * @property int $id
 * @property string $reason
 * @property string $custom
 * @property string $tier
 * @property string $duration
 * @property Carbon $created_at
 */
class SubscriptionCancellation extends Model
{
    use HasUser;

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
}
