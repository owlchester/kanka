<?php

namespace App\Models\Pivots;

use App\Models\Item;
use App\Models\Quest;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class QuestItem
 * @package App\Models
 * @property integer $item_id
 * @property Item $item
 * @property integer $quest_id
 * @property Quest $quest
 * @property string $description
 * @property string $role
 * @property boolean $is_private
 */
class QuestItem extends Pivot
{
    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * ACL Trait config
     * Tell the ACL trait that we aren't looking on this model but on items.
     */
    public $entityType = 'item';
    public $aclFieldName = 'item_id';

    /**
     * @var string
     */
    public $table = 'quest_item';

    /**
     * @var array
     */
    protected $fillable = [
        'quest_id',
        'item_id',
        'description',
        'role',
        'is_private'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest', 'quest_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
