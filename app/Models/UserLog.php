<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 * @package App\Models
 *
 * @property int $type_id
 * @property string $ip
 * @property string $country
 * @property Carbon $created_at
 */
class UserLog extends Model
{
    use HasUser;
    use MassPrunable;

    public const TYPE_LOGIN = 1;
    public const TYPE_LOGOUT = 2;
    public const TYPE_AUTOLOGIN = 3;
    public const TYPE_UPDATE = 4;
    public const TYPE_BANNED_LOGIN = 5;
    public const TYPE_SUB_NEW = 10;
    public const TYPE_SUB_CANCEL = 11;
    public const TYPE_SUB_UPGRADE = 12;
    public const TYPE_SUB_DOWNGRADE = 13;
    public const TYPE_SUB_FAIL = 15;
    public const TYPE_SUB_PAYPAL = 16;

    public const TYPE_CAMPAIGN_NEW = 20;
    public const TYPE_CAMPAIGN_JOIN = 21;
    public const TYPE_CAMPAIGN_LEAVE = 22;
    public const TYPE_CAMPAIGN_DELETE = 23;

    public const TYPE_PASSWORD_UPDATE = 30;
    public const TYPE_PASSWORD_RESET = 31;
    public const TYPE_PASSWORD_REQUEST = 32;
    public const TYPE_PASSWORD_ADMIN_UPDATE = 35;

    public const TYPE_EMAIL_UPDATE = 40;
    public const TYPE_SOCIAL_SWITCH = 41;
    public const TYPE_CURRENCY_SWITCH = 42;

    public const TYPE_USER_SWITCH = 50;
    public const TYPE_USER_REVERT = 51;
    public const TYPE_USER_SWITCH_LOGIN = 52;

    public const PURGE_WARNING_FIRST = 60;
    public const PURGE_WARNING_SECOND = 61;

    public const NOTIFY_YEARLY_SUB = 70;

    public const TYPE_FAILED_CHARGE_EMAIL = 80;
    public const TYPE_YEARLY_RENEW_WARNING = 81;
    public const TYPE_SUB_CANCEL_MANUAL = 82;
    public const TYPE_SUB_CANCEL_AUTO = 83;

    public const TYPE_PAYMENT_EDIT = 86;
    public const TYPE_PAYMENT_AUTO = 87;

    public const TYPE_CAMPAIGN_BOOST = 90;
    public const TYPE_CAMPAIGN_UPGRADE_BOOST = 91;
    public const TYPE_CAMPAIGN_SUPERBOOST = 92;
    public const TYPE_CAMPAIGN_UNBOOST = 93;
    public const TYPE_CAMPAIGN_UNBOOST_AUTO = 94;
    public const TYPE_CAMPAIGN_PREMIUM = 95;

    public $connection = 'logs';

    public $table = 'user_logs';

    protected $fillable = [
        'user_id',
        'type_id',
        'ip'
    ];

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        return static::where('updated_at', '<=', now()->subMonths(6));
    }
}
