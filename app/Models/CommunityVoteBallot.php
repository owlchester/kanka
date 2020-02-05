<?php
/**
 * Description of
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommunityVoteBallot
 * @package App\Models
 *
 * @property int $id
 * @property int $community_vote_id
 * @property int $user
 * @property string $vote
 */
class CommunityVoteBallot extends Model
{
    public $fillable = [
        'community_vote_id',
        'user_id',
        'vote'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vote()
    {
        return $this->belongsTo(CommunityVote::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
