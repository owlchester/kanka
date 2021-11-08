<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CharacterTrait
 * @package App\Models
 *
 * @property integer $character_id
 * @property string $name
 * @property string $entry
 * @property int $section_id
 * @property boolean $is_private
 * @property integer $default_order
 */
class CharacterTrait extends Model
{
    /**
     * Traits
     */
    use VisibleTrait;
    use Paginatable;

    const SECTION_APPEARANCE = 1;
    const SECTION_PERSONALITY = 2;
    /**
     * @var array
     */
    protected $fillable = [
        'character_id',
        'name',
        'entry',
        'section_id',
        'created_by',
        'is_private',
        'default_order',
    ];


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
        return $query->where('section_id', self::SECTION_PERSONALITY);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAppearance($query)
    {
        return $query->where('section_id', self::SECTION_APPEARANCE);
    }
}
