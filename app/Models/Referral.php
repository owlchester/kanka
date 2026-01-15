<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property Carbon $created_at
 * @property Carbon $revoked_at
 */
class Referral extends Model
{
    use HasTimestamps;
    use HasUser;

    public function getRouteKeyName()
    {
        return 'code';
    }


    public $fillable = [
        'user_id',
        'code'
    ];

}
