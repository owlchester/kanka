<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property string $token
 * @property int $created_by
 * @property int $campaign_id
 * @property Campaign $campaign
 * @property User $user
 */
class AdminInvite extends Model
{
    use Filterable, Sortable, Searchable;

    public $sortableColumns = [
        'token',
        'created_by',
        'campaign_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
