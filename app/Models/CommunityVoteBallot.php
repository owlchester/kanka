<?php

/**
 * Description of
 */

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CommunityVoteBallot
 * @package App\Models
 *
 * @property int $id
 * @property int $community_vote_id
 * @property string $vote
 */
class CommunityVoteBallot extends Model
{
    use HasUser;

    public $fillable = [
        'community_vote_id',
        'user_id',
        'vote'
    ];

    public function vote(): BelongsTo
    {
        return $this->belongsTo(CommunityVote::class);
    }
}
