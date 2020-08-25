<?php
/**
 * Description of
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommunityEventEntry
 * @package App\Models
 *
 * @property int $id
 * @property int $community_event_id
 * @property int $user
 * @property string $vote
 *
 * @property CommunityEvent $event
 * @property User $created_by
 */
class CommunityEventEntry extends Model
{
    public $fillable = [
        'community_event_id',
        'comment',
        'link',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(CommunityEvent::class, 'community_event_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function entity()
//    {
//        return $this->belongsTo(Entity::class);
//    }
}
