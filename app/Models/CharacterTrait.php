<?php

namespace App\Models;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

class CharacterTrait extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'character_id',
        'name',
        'entry',
        'section',
        'created_by',
        'is_private',
    ];

    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    public function scopePersonality($query)
    {
        return $query->where('section', 'personality');
    }
}
