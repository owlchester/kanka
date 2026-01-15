<?php

namespace App\Models;

use App\Enums\ReferralEventType;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property ?int $created_by
 * @property ?int $referred_by
 * @property ReferralEventType $type
 */
class ReferralEvent extends Model
{
    use HasTimestamps;

    public $fillable = [
        'created_by',
        'referred_by',
        'type',
    ];

    public $casts = [
        'type' => ReferralEventType::class,
    ];
}
