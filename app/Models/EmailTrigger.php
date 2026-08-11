<?php

namespace App\Models;

use App\Enums\EmailTrigger as EmailTriggerEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property EmailTriggerEnum $trigger_id
 * @property int|null $cohort
 * @property bool $is_active
 * @property string $template
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class EmailTrigger extends Model
{
    protected $casts = [
        'trigger_id' => EmailTriggerEnum::class,
        'cohort' => 'integer',
        'is_active' => 'boolean',
    ];
}
