<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibleTrait;

/**
 * Class QuestItem
 * @package App\Models
 * @property integer $item_id
 * @property Item $item
 * @property string $description
 * @property string $role
 * @property string $colour
 * @property integer $impact
 */
class QuestItem extends QuestElement
{
    /**
     * ACL Trait config
     * Tell the ACL trait that we aren't looking on this model but on items.
     */
    public $entityType = 'item';
    public $aclFieldName = 'item_id';

    /**
     * @var string
     */
    public $table = 'quest_items';

    /**
     * @var array
     */
    protected $fillable = [
        'quest_id',
        'item_id',
        'description',
        'role',
        'colour',
        'impact',
        'is_private'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
