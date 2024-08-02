<?php

/**
 * Description of
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function vote(): BelongsTo
    {
        return $this->belongsTo(CommunityVote::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
