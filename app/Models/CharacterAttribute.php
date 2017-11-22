<?php

namespace App\Models;

use App\MiscModel;
use App\Traits\VisibleTrait;

class CharacterAttribute extends MiscModel
{
    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * @var string
     */
    public $table = 'character_attributes';

    /**
     * @var array
     */
    protected $fillable = ['character_id', 'attribute', 'value', 'is_private'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Character', 'character_id');
    }
}
