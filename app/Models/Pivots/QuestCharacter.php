<?php

namespace App\Models\Pivots;

use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class QuestCharacter
 * @package App\Models
 * @property integer $character_id
 * @property Character $character
 * @property string $description
 * @property string $role
 */
class QuestCharacter extends Pivot
{
    /**
     * Traits
     */
    use VisibleTrait, SimpleSortableTrait;

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
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }
}
