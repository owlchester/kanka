<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\VisibleTrait;

class QuestCharacter extends MiscModel
{
    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * @var string
     */
    public $table = 'quest_characters';

    /**
     * @var array
     */
    protected $fillable = ['quest_id', 'character_id', 'description', 'is_private'];

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
