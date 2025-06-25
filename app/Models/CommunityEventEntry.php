<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CommunityEventEntry
 *
 * @property int $id
 * @property int $community_event_id
 * @property string $vote
 * @property int $created_by
 * @property CommunityEvent $event
 */
class CommunityEventEntry extends Model
{
    use HasUser;

    protected string $userField = 'created_by';

    public $fillable = [
        'community_event_id',
        'comment',
        'link',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CommunityEvent, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(CommunityEvent::class, 'community_event_id');
    }
}
