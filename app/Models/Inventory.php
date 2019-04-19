<?php

namespace App\Models;

use App\Traits\EntityAclTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $item_id
 * @property integer $amount
 * @property string $position
 * @property string $visibility
 * @property Item $item
 * @property Entity $entity
 */
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
