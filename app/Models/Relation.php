<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Relation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'owner_id',
        'target_id',
        'relation',
        'is_private',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\Entity', 'owner_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target()
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }
}
