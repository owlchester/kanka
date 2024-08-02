<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CommunityEventEntry
 * @package App\Models
 *
 * @property int $id
 * @property int $community_event_id
 * @property int $user
 * @property string $vote
 * @property int $created_by
 *
 * @property CommunityEvent $event
 */
class CommunityEventEntry extends Model
{
    public $fillable = [
        'community_event_id',
        'comment',
        'link',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(CommunityEvent::class, 'community_event_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
