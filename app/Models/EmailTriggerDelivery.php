<?php

namespace App\Models;

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger as EmailTriggerEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $email_trigger_id
 * @property string $stage
 * @property EmailTriggerEnum $trigger
 * @property EmailAudience $audience
 * @property string $template
 * @property string $status
 * @property int $attempts
 * @property string|null $provider_message_id
 * @property string|null $error
 * @property Carbon|null $sent_at
 * @property Carbon|null $failed_at
 */
class EmailTriggerDelivery extends Model
{
    public const STATUS_SENDING = 'sending';

    public const STATUS_SENT = 'sent';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'email_trigger_id',
        'stage',
        'trigger',
        'audience',
        'template',
        'status',
        'attempts',
        'provider_message_id',
        'error',
        'sent_at',
        'failed_at',
    ];

    protected function casts(): array
    {
        return [
            'trigger' => EmailTriggerEnum::class,
            'audience' => EmailAudience::class,
            'attempts' => 'integer',
            'sent_at' => 'datetime',
            'failed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
