<?php

namespace App\Models;

use App\Enums\PricingPeriod;
use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriptionSource
 *
 * @property int $id
 * @property string $source_id
 * @property string $charge_id
 * @property string $tier
 * @property string $period
 * @property string $status
 * @property string $method
 */
class SubscriptionSource extends Model
{
    use HasUser;

    public $timestamps = true;

    public $fillable = [
        'source_id',
        'charge_id',
        'tier',
        'period',
        'user_id',
        'status',
        'method',
    ];

    public function currency(): string
    {
        return in_array($this->method, ['giropay', 'sofort', 'ideal']) ? 'eur' : 'eur';
    }

    public function plan(): string
    {
        $tierName = $this->tier === Pledge::ELEMENTAL ? Pledge::ELEMENTAL : Pledge::OWLBEAR;
        $period = $this->period === 'yearly' ? PricingPeriod::Yearly : PricingPeriod::Monthly;

        return TierPrice::active()
            ->whereHas('tier', fn ($query) => $query->where('name', $tierName))
            ->where('currency', $this->currency())
            ->where('period', $period)
            ->sole()
            ->stripe_id;
    }
}
