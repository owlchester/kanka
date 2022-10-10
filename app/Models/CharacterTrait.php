<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CharacterTrait
 * @package App\Models
 *
 * @property int $id
 * @property int $character_id
 * @property string $name
 * @property string $entry
 * @property int $section_id
 * @property boolean $is_private
 * @property integer $default_order
 */
class CharacterTrait extends Model
{
    use Paginatable;

    public const SECTION_APPEARANCE = 1;
    public const SECTION_PERSONALITY = 2;

    /** @var string[]  */
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
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePersonality(Builder $query): Builder
    {
        return $query->where('section_id', self::SECTION_PERSONALITY);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeAppearance(Builder $query): Builder
    {
        return $query->where('section_id', self::SECTION_APPEARANCE);
    }
}
