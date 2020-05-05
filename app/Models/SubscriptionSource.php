<?php


namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriptionSource
 * @package App\Models
 *
 * @property int $id
 * @property string $source_id
 * @property string $charge_id
 * @property string $tier
 * @property string $period
 * @property int $user_id
 * @property string $status
 * @property string $method
 *
 * @property User $user
 */
class SubscriptionSource extends Model
{
    public $timestamps = true;

    public $fillable = [
        'source_id',
        'charge_id',
        'tier',
        'period',
        'user_id',
        'status',
        'method'
    ];

    /**
     * @return string
     */
    public function currency(): string
    {
        return in_array($this->method, ['giropay', 'sofort', 'ideal']) ? 'eur' : 'eur';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return string
     */
    public function plan(): string
    {
        if ($this->tier === Patreon::PLEDGE_ELEMENTAL) {
            if ($this->period === 'yearly') {
                return config('subscription.elemental.eur.yearly');
            }
            return config('subscription.elemental.eur.monthly');
        }
        if ($this->period === 'yearly') {
            return config('subscription.owlbear.eur.yearly');
        }
        return config('subscription.owlbear.eur.monthly');
    }
}
