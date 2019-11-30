<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibleTrait;

/**
 * Class QuestCharacter
 * @package App\Models
 * @property integer $character_id
 * @property Character $character
 * @property string $description
 * @property string $role
 * @property string $colour
 * @property integer $impact
 */
class QuestCharacter extends QuestElement
{

    /**
     * ACL Trait config
     * Tell the ACL trait that we aren't looking on this model but on locations.
     */
    public $entityType = 'character';
    public $aclFieldName = 'character_id';

    /**
     * @var string
     */
    public $table = 'quest_characters';

    /**
     * @var array
     */
    protected $fillable = [
        'quest_id',
        'character_id',
        'description',
        'role',
        'colour',
        'impact',
        'is_private'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }
}
