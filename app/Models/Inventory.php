<?php

namespace App\Models;

use App\Traits\EntityAclTrait;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /**
     * Fillable fields
     */
    public $fillable = [
        'entity_id',
        'item_id',
        'amount',
        'position',
        'visibility',
    ];

    use EntityAclTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Item');
    }
}
