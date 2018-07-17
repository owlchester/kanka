<?php

namespace App\Models;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CharacterTrait
 * @package App\Models
 *
 * @property integer $character_id
 * @property string $name
 * @property string $entry
 * @property string $section
 * @property boolean $is_private
 * @property integer $default_order
 */
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
        'default_order',
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopePersonality($query)
    {
        return $query->where('section', 'personality');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAppearance($query)
    {
        return $query->where('section', 'appearance');
    }
}
