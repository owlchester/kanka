<?php
/**
 * Description of
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CommunityVoteBallot extends Model
{
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
