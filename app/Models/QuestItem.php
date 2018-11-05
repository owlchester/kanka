<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\AclTrait;
use App\Traits\VisibleTrait;

class QuestItem extends MiscModel
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
    public $table = 'quest_items';

    /**
     * @var array
     */
    protected $fillable = ['quest_id', 'item_id', 'description', 'is_private'];

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
