<?php

namespace App\Models;

use App\Traits\OrderableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Relation extends Model
{

    /**
     *
     */
    use VisibleTrait;
    use OrderableTrait;

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'relations/';

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
